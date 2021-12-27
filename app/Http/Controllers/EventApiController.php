<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventApiController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::get();
        if ($request->query('sort_by')) {
            if ($request->query('order') == 'descending') {
                $events = $events->sortByDesc($request->query('sort_by'));
            } else {
                $events = $events->sortBy($request->query('sort_by'));
            }
        }
        if ($request->query('organizer')) {
            $events = $events->where('organizer', $request->query('organizer'));
        }
        if ($request->query('tag')) {
            dd("to do");
        }

        dd(json_encode($events, JSON_PRETTY_PRINT));
    }
}
