<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NotificationReceived;
use App\Models\Attendance;
use App\Models\Event;
use App\Models\Location;
use App\Models\User;
use App\Models\File;
use App\Models\Tag;
use App\Models\AttendanceRequest;


use Carbon\Carbon;
use Validator;

use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('is_admin', 'false')->get();
        $tags = Tag::all();
        $events = Event::search($request->query('global'));
        if ($request->filled('sort_by')) {
            if ($request->query('order') == 'descending') {
                $events = $events->orderBy($request->query('sort_by'), 'desc');
            } else {
                $events = $events->orderBy($request->query('sort_by'), 'asc');
            }
        } else {
            $events = $events->orderBy('date', 'desc');
        }
        if ($request->filled('organizer')) {
            $user = User::where('username', $request->query('organizer'))->first();
            $events = $events->where('organizer_id', '=', $user->id ?? null);
        }
        if ($request->filled('tag')) {
            $events = $events->tag($request->query('tag'));
        }
        if ($request->filled('state')) {
            $events = $events->where('event_state', '=', $request->query('state'));
        }
        if ($request->filled('begin_date')) {
            $date = date('Y-m-d', strtotime($request->query('begin_date')));
            $events = $events->where('date', '>=', $date);
        }
        if ($request->filled('end_date')) {
            $date = date('Y-m-d', strtotime($request->query('end_date')));
            $events = $events->where('date', '<=', $date);
        }
        return view('pages.events.browse', ['tags' => $tags, 'users' => $users, 'events' => $events->paginate($request->size ?? 6)->withQueryString(), 'request' => $request]);
    }

    public function getCardList($events)
    {
        return view('partials.events.cardlist', compact('events'));
    }

    public function indexCreate()
    {
        if (!Auth::check()) {
            return redirect()->route("login");
        }
        $tags = Tag::all();
        return view("pages.events.edit", ['tags' => $tags]);
    }

    public function indexEdit($id)
    {
        $event = Event::findOrFail($id);
        $tags = Tag::all();
        return view("pages.events.edit", ['tags' => $tags, 'event' => $event]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|mimes:png,jpg,jpe',
            'date' => 'required|date|after:now'
        ], $messages = [
            'date.after' => 'An event cannot be set in the past!',
        ]);

        $file = null;

        if ($validator->fails()) {
            return redirect()
                ->route('createEvent')
                ->withErrors($validator)
                ->withInput();
        }

        $event = Event::create([
            'organizer_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'event_state' => 'due',
            'date' => $request->date,
            'is_private' => $request->restriction === 'private' ? 'true' : 'false'
        ]);
        $event->tags()->attach($request->tags);


        if ($request->cover_image) {
            $filename = 'event' . $event->id . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('storage'), $filename);
            $relativePath = 'storage/' . $filename;

            $curr_img = File::where('path', $relativePath)->get()->first();
            if ($curr_img != null) {
                $curr_img->delete();
            }

            $file = File::create([
                'path' => $relativePath,
                'name' => $request->file('cover_image')->getClientOriginalName()
            ]);
            $event->cover_image_id = $file->id;
        }

        if ($request->city) {
            $location = Location::create([
                'city' => $request->city,
                'postcode' => $request->postcode,
                'country' => $request->country,
                'name' => $request->display_name,
                'lat' => $request->lat,
                'long' => $request->long
            ]);
            $event->location_id = $location->id;
        }
        $event->save();
        return redirect()->route('event', ['id' => $event->id]);
    }

    public function update(Request $request, $id)
    {
        if ($request->id == null) {
            return;
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|mimes:png,jpg,jpe',
            'date' => 'required|date|after:now'
        ], $messages = [
            'date.after' => 'An event cannot be set in the past!',
        ]);

        $file = null;

        if ($validator->fails()) {
            return redirect()
            ->route('editEvent', ['id' => $request->id])
            ->withErrors($validator)
            ->withInput();
        }

        $event = Event::findOrFail($request->id);
        if ($event->organizer_id != Auth::user()->id) {
            return;
        }

        if (!is_null($request->title) && $event->description != $request->description) {
            $event->description = $request->description;
        }

        if (!is_null($request->title) && $event->title != $request->title) {
            $event->title = $request->title;
        }

        if (!is_null($request->date)) {
            $old_date = Carbon::parse($event->date);
            $new_date = Carbon::parse($request->date);
            if ($old_date->ne($new_date)) {
                $event->date = $request->date;
            }
        }

        if (!is_null($request->restriction)) {
            $event->is_private = $request->restriction === 'private' ? 'true' : 'false';
        }

        if ($request->cover_image) {
            $filename = 'event' . $event->id . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('storage'), $filename);
            $relativePath = 'storage/' . $filename;

            $curr_img = File::where('path', $relativePath)->get()->first();
            if ($curr_img != null) {
                $curr_img->delete();
            }

            $file = File::create([
                'path' => $relativePath,
                'name' => $request->file('cover_image')->getClientOriginalName()
            ]);
            if ($event->image != null) {
                $event->image->delete();
            }
            $event->cover_image_id = $file->id;
        }

        if ($request->tags) {
            $event->tags()->detach();
            $event->tags()->attach($request->tags);
        }

        if ($request->city) {
            $event->location->delete();

            $location = Location::create([
                'city' => $request->city,
                'postcode' => $request->postcode,
                'country' => $request->country,
                'name' => $request->display_name,
                'lat' => $request->lat,
                'long' => $request->long
            ]);
            $event->location_id = $location->id;
        }

        $event->save();
        return redirect()->route('event', ['id' => $event->id]);
    }

    public function get($id)
    {
        $event = Event::find($id);
        $this->authorize('view', $event);
        $isAttendee = false;
        foreach ($event->attendances as $attendance) {
            if (Auth::check()) {
                if ($attendance->attendee_id == Auth::user()->id) {
                    $isAttendee =  true;
                }
            } else {
                $isAttendee = false;
            }
        }
        $users = User::where('is_admin', 'false')->get();
        $invites = $event->getInvites();
        $userInvite = $event->attendanceRequests()->getQuery()->where('attendee_id', Auth::id())->where('is_invite', 'true')->where('is_handled', 'false')->first();
        $ages = $event->getAgeStats();
        $genders = $event->getGenderStats();
        return view("pages.events.view", compact('users', 'event', 'invites', 'ages', 'genders', 'isAttendee', 'userInvite', 'isAttendee'));
    }

    public function joinRequest($id)
    {
        $event = Event::find($id);
        $this->authorize('joinRequest', $event);
        $joinRequest = AttendanceRequest::where('event_id', $event->id)->where('attendee_id', Auth::id())->first();
        if ($joinRequest != null && $joinRequest->is_handled) {
            $joinRequest->is_handled = false;
            $joinRequest->is_invite = false;
            $joinRequest->is_accepted = false;
            $joinRequest->save();
        } else {
            AttendanceRequest::create([
                'event_id' => $id,
                'attendee_id' => Auth::user()->id,
                'is_invite' => false
            ]);
        }
        event(new NotificationReceived('join request', [$event->organizer]));
        return redirect()->route('event', ['id' => $id]);
    }


    public function inviteUser($username)
    {
        $user = User::where('username', $username);
        if ($user == null) {
            return;
        }
        foreach ($user_ as $this->attendances) {
            if ($user_id == $user->id) {
                return;
            }
        }

        AttendanceRequest::create([
            'event_id' => $this->id,
            'attendee_id' => $user->id,
            'is_invite' => true
        ]);
    }

    public function answerInvite(Request $request)
    {
        $event = Event::find($request->eventId);
        $attendanceRequest = AttendanceRequest::find($request->inviteId);
        $this->authorize("answerInvite", $attendanceRequest);

        event(new NotificationReceived('answer invite ', [$event->organizer]));
        if ($request->get('accept')) {
            $attendance = Attendance::create([
                'event_id' => $event->id,
                'attendee_id' => Auth::id()
            ]);
            $attendanceRequest->is_accepted = true;
        }
        //$attendanceRequest->delete();
        $attendanceRequest->is_handled = true;
        $attendanceRequest->save();
        return redirect()->route('event', ['id' => $event->id]);
    }

    public function disable(Request $request, $event_id)
    {
        $event = Event::find($event_id);
        if ($event != null) {
            $this->authorize('delete', $event);
            $organizer_id = $event->organizer_id;
            $event->is_disabled = true;
            $event->save();
            //$event->delete();
            event(new NotificationReceived('event deleted', $event->attendees));
        }
        if (Auth::user()->id === $organizer_id) {
            return redirect()->route('profile', ['username' => Auth::user()->username]);
        } else {
            return redirect()->route('reportsDash');
        }
    }
}
