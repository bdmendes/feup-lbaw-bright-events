<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;

class EventApiController extends Controller
{
    /*     public function index(Request $request)
        {
            $events = Event::search($request->query('global'))->get();
            if ($request->has('sort_by')) {
                if ($request->query('order') == 'descending') {
                    $events = $events->sortByDesc($request->query('sort_by'));
                } else {
                    $events = $events->sortBy($request->query('sort_by'));
                }
            }
            if ($request->has('organizer')) {
                $events = $events->where('organizer_id', $request->query('organizer'));
            }
            if ($request->has('location')) {
                $events = $events->where('location_id', $request->query('location'));
            }
            if ($request->has('tag')) {
                $events = $events->filter(function ($item) use ($request) {
                    foreach ($item->tags as $tag) {
                        if ($tag->name == $request->query('tag')) {
                            return true;
                        }
                    }
                    return false;
                });
            }
            if ($request->has('state')) {
                $events = $events->where('event_state', $request->query('state'));
            }
            if ($request->has('begin_date')) {
                $date = date('Y-m-d', strtotime($request->query('begin_date')));
                $events = $events->filter(function ($item) use ($date) {
                    return data_get($item, 'date') >= $date;
                });
            }
            if ($request->has('end_date')) {
                $date = date('Y-m-d', strtotime($request->query('end_date')));
                $events = $events->filter(function ($item) use ($date) {
                    return data_get($item, 'date') <= $date;
                });
            }
            if ($request->has('offset')) {
                $events = $events->skip($request->query('offset'));
            }
            if ($request->has('size')) {
                $events = $events->take($request->query('size'));
            }
            dd(json_encode($events, JSON_PRETTY_PRINT));
        }

        public function update(Request $request)
        {
            $event = Event::findOrFail($request->id);
            if (!is_null($request->title)) {
                $event->title = $request->title;
            }
            if (!is_null($request->description)) {
                $event->title = $request->description;
            }
            if (!is_null($request->is_private)) {
                $event->is_private = $request->boolean(is_private);
            }
            if (!is_null($request->organizer)) {
                $user = User::find($request->organizer);
                if ($user == null) {
                    return response()->json([
                        "message" => "Provided user was not found"
                        ], 500);
                }
                $event->organizer_id = $request->organizer;
            }
            $event->save();
            return response()->json([
                "message" => "Ok. Event updated."
            ], 200);
        } */

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
}
