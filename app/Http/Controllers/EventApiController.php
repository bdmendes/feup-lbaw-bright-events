<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventApiController extends Controller
{
    public function index(Request $request)
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
            $events = $events->where('organizer', $request->query('organizer'));
        }
        if ($request->has('location')) {
            $events = $events->where('location', $request->query('location'));
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
        dd(json_encode($events, JSON_PRETTY_PRINT));
    }
}
