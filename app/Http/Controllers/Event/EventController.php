<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\File;
use App\Models\Tag;

class EventController extends Controller
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
        } else {
            $events = $events->take(5);
        }

        return view('pages.events', ["events" => $events]);
    }

    public function indexCreate()
    {
        $tags = Tag::all();
        return view("pages.events.edit", ['tags' => $tags]);
    }

    public function create(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'cover_image' => 'mimes:png,jpg,jpe'
        ]);

        $file = null;

        $event = Event::create([
            'organizer_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->body,
            'event_state' => 'due',
            'date' => $request->date,
            'is_private' => $request->restriction === 'private' ? 'true' : 'false'
        ]);
        $event->tags()->attach($request->tags);

        if ($request->cover_image) {
            $filename = 'event' . $event->id . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('storage'), $filename);
            $relativePath = 'storage/' . $filename;

            $file = File::create([
                'path' => $relativePath,
                'name' => $request->file('cover_image')->getClientOriginalName()
            ]);
            $event->cover_image_id = $file->id;
            $event->save();
        }

        return redirect()->route('event', ['id' => $event->id]);
    }

    public function get($id)
    {
        $event = Event::find($id);
        if ($event->is_private) {
            $this->authorize('view', Auth::user(), $event);
        }
        return view("pages.events.view", ['event' => $event]);
    }
}
