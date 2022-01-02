@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container w-md-75">
        <div class="w-100">
            @if ($event->image ?? ('' && $event->image->path ?? ''))
                <img src="/{{ $event->image->path }}" class="eventBackground mx-auto" />
            @else
                <div class="eventBackground mx-auto bg-dark" style="height: 300px"> </div>
            @endif
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
        @include('partials.events.tabView', ['event' => $event])
    </div>
@endsection
