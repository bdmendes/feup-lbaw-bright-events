@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="d-flex align-items-lg-center flex-column mx-auto col-lg-6 col-md-8 col-sm-10 col-xs-12 p-1">
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
                {{ $event->organizer->name ?? 'Deleted User' }}
            </div>
            <div class="p-3 w-100">
                <label> Tags: </label>
                @include("partials.events.tags", ['event' => $event])
            </div>
        </div>
        @include('partials.events.tabview', ['event' => $event])
    </div>
@endsection
