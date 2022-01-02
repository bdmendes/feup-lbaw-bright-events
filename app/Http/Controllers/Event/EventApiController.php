<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Attendance;
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
        $event = Event::findOrFail($request->id);
        dd(json_encode($event->comments, JSON_PRETTY_PRINT));
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

        return response("Successfully joined attendance list.", 200);
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

        return response("Successfully joined attendance list.", 200);
    }
}
