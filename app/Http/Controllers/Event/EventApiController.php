<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Comment;
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
        if ($event == null) return '';
        $start = $request->start ?? 0;
        $size = $request->size ?? 5;
        $comments = $event->comments()->getQuery()->orderBy('date', 'asc')->skip($start)->take($size)->get();
        return view('partials.events.commentList', compact('comments'));
    }

    public function submitComment(Request $request){
        $event = Event::find($request->eventId);
        if ($event == null) return 'Could not find event';
        $data = json_decode($request->getContent(), true);
        if ($data["body"] == null || $data["author"] == null) return 'Invalid data!';
        $comment = Comment::create([
            'event_id' => $request->eventId,
            'commenter_id' => $data["author"], // change auth...
            'body' => $data["body"]
        ]);
        if ($comment == null) return 'Could not create comment';
        return view('partials.events.comment', compact('comment'));
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
        return response()->json(array('success' => true, 'html'=>$returnHTML), 200);
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
        AttendanceRequest::create([
            'event_id' => $event->id,
            'attendee_id' => $user->id,
            'is_invite' => true
        ]);
        $returnHTML = view('partials.users.smallCard')->with('user', $user)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML), 200);
    }

    public function getInvites(Request $request)
    {
        return response("Not implemented yet", 501);
    }
}
