<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\File;
use App\Models\Tag;

use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request)
    {
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
            $events = $events->where('organizer_id', '=', $request->query('organizer'));
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
        return view('pages.events.browse', ['events' => $events->paginate($request->size ?? 5)->withQueryString(), 'request' => $request]);
    }

    public function getCardList($events)
    {
        return view('partials.events.cardlist', compact('events'));
    }

    public function indexCreate()
    {
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
        dd($request);
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'cover_image' => 'mimes:png,jpg,jpe'
        ]);

        $file = null;

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

            $file = File::create([
                'path' => $relativePath,
                'name' => $request->file('cover_image')->getClientOriginalName()
            ]);
            $event->cover_image_id = $file->id;
            $event->save();
        }

        return redirect()->route('event', ['id' => $event->id]);
    }

    public function update(Request $request, $id)
    {
        dd($request);
        if ($request->id == null) {
        }
        $event = Event::find($request->id);
        if ($event->organizer_id != Auth::user()->id) {
        }
        $event->description = $request->description;
        $event->title = $request->title;
        $event->date = $request->date;
        $event->is_private = $request->restriction === 'private' ? 'true' : 'false';

        if ($request->cover_image) {
            $filename = 'event' . $event->id . '.' . $request->cover_image->extension();
            $request->cover_image->move(public_path('storage'), $filename);
            $relativePath = 'storage/' . $filename;

            $file = File::create([
                'path' => $relativePath,
                'name' => $request->file('cover_image')->getClientOriginalName()
            ]);
            if ($event->image != null) {
                $event->image->delete();
            }
            $event->cover_image_id = $file->id;
        }

        $event->tags = $request->tags;


        $event->save();
    }
    public function get($id)
    {
        $event = Event::find($id);
        if ($event->is_private) {
            $this->authorize('view', Auth::user(), $event);
        }
        return view("pages.events.view", ['event' => $event]);
    }

    public function delete($id)
    {
        $event = Event::find($id);
        if ($event == null) {
        }
        if (Auth::user()->id == $event->organizer_id) {
            $event->delete();
        }
    }
}
