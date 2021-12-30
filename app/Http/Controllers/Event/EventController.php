<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Tag;

class EventController extends Controller
{
    public function indexCreate()
    {
        $tags = Tag::all();
        return view("pages.events.edit", ['tags' => $tags]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $event = Event::create([
            'organizer_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->body,
            'event_state' => 'due',
            'date' => $request->date,
            'is_private' => $request->restriction === 'private' ? 'true' : 'false'
        ]);
        $event->tags()->attach($request->tags);

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
