<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class EventController extends Controller
{
    public function indexCreate()
    {
        return view("pages.events.edit");
    }

    public function create($request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required'
        ]);

        $event = Event::create([
            'organizer' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body
        ]);

        return redirect()->route('event', ['id' => $event->id]);
    }
}
