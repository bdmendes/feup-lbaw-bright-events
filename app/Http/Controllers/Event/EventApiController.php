<?php

namespace App\Http\Controllers\Event;

use App\Events\NotificationReceived;
use App\Events\EventPusher;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Comment;
use App\Models\Poll;
use App\Models\PollOption;
use App\Models\AttendanceRequest;
use Auth;

class EventApiController extends Controller
{
    public function getAttendees(Request $request)
    {
        $event = Event::findOrFail($request->id);
        dd(json_encode($event->attendees, JSON_PRETTY_PRINT));
    }

    public function getComments(Request $request)
    {
        $event = Event::find($request->eventId);
        if ($event == null) {
            return 'Event not found';
        }
        $start = $request->start ?? 0;
        $size = $request->size ?? 5;
        $comments_ = $event->comments()->getQuery();
        if ($request->filled('parent')) {
            $comments_ = $comments_->where('parent_id', $request->parent);
        } else {
            $comments_ = $comments_->where('parent_id', null);
        }
        $comments = $comments_->skip($start)->take($size)->orderBy('date', 'desc')->get();
        return view('partials.events.commentList', compact('comments'));
    }

    public function getCommentsCount(Request $request)
    {
        $event = Event::find($request->eventId);
        if ($event == null) {
            return 'Event not found';
        }
        $count = count($event->comments()->getQuery()->where('parent_id', null)->get());
        return strval($count);
    }

    public function submitComment(Request $request)
    {
        $event = Event::find($request->eventId);
        if ($event == null) {
            return 'Could not find event';
        }
        $data = json_decode($request->getContent(), true);
        if ($data["body"] == null || Auth::id() == null) {
            return 'Invalid data!';
        }
        $comment = Comment::create([
            'event_id' => $request->eventId,
            'commenter_id' => Auth::id(),
            'parent_id' => $request->parent ?? null,
            'body' => $data["body"]
        ]);
        event(new NotificationReceived('new comment', [$event->organizer]));
        event(new EventPusher('comment', $comment->id, $event));
        if ($comment == null) {
            return 'Could not create comment';
        }
        return view('partials.events.comment', compact('comment'));
    }

    public function getComment(Request $request)
    {
        $event = Event::find($request->eventId);
        $comment = Comment::find($request->commentId);
        if ($event == null || $comment == null || $comment->event_id != $request->eventId) {
            return response("Invalid request data", 404);
        }
        return view('partials.events.comment', compact('comment'));
    }

    public function deleteComment(Request $request)
    {
        if (!Auth::check()) {
            return response("User is not logged in", 403);
        }
        $comment = Comment::find($request->commentId);
        if ($comment == null) {
            return response("Comment not found", 404);
        }
        $comment->delete();
        return response("Comment successfully deleted", 200);
    }

    public function voteOnPoll(Request $request, $is_delete)
    {
        if (!Auth::check()) {
            return response("User is not logged in", 403);
        }
        $poll = Poll::find($request->pollId);
        if ($poll == null) {
            return response("Poll not found", 404);
        }
        $poll_option = PollOption::find($request->pollOption);
        if ($poll_option == null) {
            return response("Poll option not found", 404);
        }
        if ($is_delete) {
            $user = $poll_option->voters()->detach(Auth::id());
            if ($user == null) {
                return response("User did not previously vote for this option", 404);
            }
        } else {
            $poll_option->voters()->attach(Auth::id());
        }
        event(new EventPusher('poll', $poll->id, $poll->event));
        return response("Vote change saved successfully", 200);
    }

    public function addVote(Request $request)
    {
        return $this->voteOnPoll($request, false);
    }

    public function removeVote(Request $request)
    {
        return $this->voteOnPoll($request, true);
    }

    public function canVote($eventId, $userId)
    {
        $user = User::find($userId);
        $event = Event::find($eventId);
        return $user != null && $event != null && $event->attendances()->getQuery()->where('attendee_id', $userId)->exists();
    }

    public function submitPoll(Request $request)
    {
        $event = Event::find($request->eventId);
        if ($event == null) {
            return response("Event not found", 404);
        }
        $data = json_decode($request->getContent(), true);
        if ($data["title"] == null || $data["description"] == null || $data["options"] == null || count($data["options"]) == 0) {
            return response("Invalid request data", 403);
        }
        $poll = Poll::create([
            'title' => $data["title"],
            'description' => $data["description"],
            'event_id' => $event->id,
            'is_open' => true
        ]);
        $options = [];
        foreach ($data["options"] as $name) {
            $option = PollOption::create([
                'name' => $name,
                'poll_id' => $poll->id
            ]);
            array_push($options, $option);
        }
        $poll->options()->saveMany($options);
        $can_vote = $this->canVote($request->eventId, Auth::id());
        return response(view('partials.events.poll', compact('poll', 'can_vote')), 200);
    }

    public function getPolls(Request $request)
    {
        $event = Event::find($request->eventId);
        if ($event == null) {
            return 'Event not found';
        }
        $can_vote = $this->canVote($request->eventId, Auth::id());
        $polls = $event->polls()->getQuery()->orderBy('date', 'desc')->get();
        return view('partials.events.pollList', compact('polls', 'can_vote', 'event'));
    }

    public function getPoll(Request $request)
    {
        $event = Event::find($request->eventId);
        $poll = Poll::find($request->pollId);
        if ($event == null || $poll == null || $poll->event_id != $request->eventId) {
            return response("Invalid request data", 404);
        }
        $can_vote = $this->canVote($request->eventId, Auth::id());
        return view('partials.events.poll', compact('poll', 'can_vote'));
    }

    public function switchPollState(Request $request)
    {
        $event = Event::find($request->eventId);
        $poll = Poll::find($request->pollId);
        if ($event == null || $poll == null || $poll->event_id != $request->eventId) {
            return response("Invalid request data", 404);
        }
        $poll->is_open = !$poll->is_open;
        $poll->save();
        event(new NotificationReceived('poll state changed', $event->attendees));
        event(new EventPusher('poll', $poll->id, $event));
        return response('Poll state successfully switched', 200);
    }

    public function removePoll(Request $request)
    {
        $event = Event::find($request->eventId);
        $poll = Poll::find($request->pollId);
        if ($event == null || $poll == null || $poll->event_id != $request->eventId) {
            return response("Invalid request data", 404);
        }
        $poll->delete();
        return response("Poll successfully deleted", 200);
    }

    public function attendEventClick(Request $request)
    {
        $this->validate($request, [
            'event_id' => 'required',
            'attendee_id' => 'required',
        ]);

        Attendance::create([
            'event_id' => $request->event_id,
            'attendee_id' => $request->attendee_id
        ]);

        $user = User::find($request->attendee_id);

        $returnHTML = view('partials.users.smallCard')->with('user', $user)->render();
        return response()->json(array('success' => true, 'html' => $returnHTML), 200);
    }

    public function leaveEventClick(Request $request)
    {
        $this->validate($request, [
            'event_id' => "required",
            'attendee_id' => "required",
        ]);

        $attendance = Attendance::where("event_id", $request->event_id)->where("attendee_id", $request->attendee_id)->get()->first();

        if (is_null($attendance)) {
            return response("Attendance not found.", 404);
        }

        $attendance->delete();

        $attendanceRequest = AttendanceRequest::where("event_id", $request->event_id)->where("attendee_id", $request->attendee_id)->first();
        if ($attendanceRequest != null) {
            $attendanceRequest->delete();
        }

        return response("Successfully left attendance list.", 200);
    }

    public function invite(Request $request)
    {
        $user = User::where('username', $request->username)->get()->first();
        $event = Event::find($request->route('eventId'));
        if (empty($user) || empty($event)) {
            return response("Invalid data", 400);
        }
        foreach ($event->attendances as $attendance) {
            if ($attendance->attendee_id == $user->id) {
                return response("Is already attendee already", 203);
            }
        }

        $attendanceRequest = AttendanceRequest::where('event_id', $event->id)->where('attendee_id', $user->id)->first();
        if ($attendanceRequest != null) {
            if (!$attendanceRequest->is_invite && !$attendanceRequest->is_handled) {
                $attendance = Attendance::create([
                    'event_id' => $event->id,
                    'attendee_id' => $attendanceRequest->attendee_id
                ]);
                $attendanceRequest->is_accepted = true;
                $attendanceRequest->is_handled = true;
                $attendanceRequest->save();
                event(new NotificationReceived('answer join request', [$attendanceRequest->attendee]));
            } else {
                $attendanceRequest->is_invite = true;
                $attendanceRequest->is_accepted = false;
                $attendanceRequest->is_handled = false;
                $attendanceRequest->save();
            }
        } else {
            AttendanceRequest::create([
                'event_id' => $event->id,
                'attendee_id' => $user->id,
                'is_invite' => true
            ]);
        }
        $returnHTML = view('partials.users.smallCard')->with('user', $user)->render();

        event(new NotificationReceived('invite', [$user]));
        return response()->json(array('success' => true, 'html' => $returnHTML), 200);
    }

    public function getInvites(Request $request)
    {
        return response("Not implemented yet", 501);
    }

    public function answerJoinRequest(Request $request)
    {
        $event = Event::find($request->eventId);
        $attendanceRequest = AttendanceRequest::find($request->requestId);

        $this->authorize('acceptJoinRequest', $event);

        if ($request->accept) {
            $attendance = Attendance::create([
                'event_id' => $event->id,
                'attendee_id' => $attendanceRequest->attendee_id
            ]);
            $attendanceRequest->is_accepted = true;
        }
        //$attendanceRequest->delete();
        $attendanceRequest->is_handled = true;
        $attendanceRequest->save();
        event(new NotificationReceived('answer join request', [$attendanceRequest->attendee]));
        if ($request->accept) {
            return view('partials.users.removableSmallCard', ['attendance' => $attendance]);
        } else {
            return 'deleted';
        }
    }
}
