@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container w-md-75 border rounded p-4">
        <div class="w-100">
                <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="eventBackground mx-auto" />
        </div>
        <div class="p-1  w-100">
            <div class="p-3  w-100">
                <h1>{{ $event->title }}</h1>
            </div>

            <div class="p-3  w-100">
                <label>Date: </label>
                {{ $event->date->format('d/m/Y H:i') }}
            </div>
            <div class="p-3  w-100">
                <label>Location: </label>
                @if ($event->location ?? '')
                    {{ $event->location->pretty_print() }}
                @else
                    Not defined
                @endif

            </div>
            <div class="p-3  w-100">
                <label> Organizer: </label>
                @include('partials.users.smallCard', ['user' => $event->organizer])
            </div>
            <div class="p-3 w-100">
                <label> Tags: </label>
                @include("partials.events.tags", ['event' => $event])
            </div>
        </div>

        @include('partials.events.tabView', compact('event'))
    </div>
@endsection
