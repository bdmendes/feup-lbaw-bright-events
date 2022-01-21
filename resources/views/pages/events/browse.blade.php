@extends('layouts.app')

@section('title', 'events')



@section('content')
    @include('partials.breadcrumbs', ['pages'=>[['name' => 'Home', 'route'=> route('home')],['name' => 'Events',
    'route'=>route('browseEvents')]]])

    <div class="d-xs-block d-sm-none d-md-none d-lg-none d-xl-none p-5">
        @include('partials.events.search')
    </div>
    <div class="d-flex justify-content-end">

        <div class="d-none d-sm-block col-sm-3 col-md-3 col-lg-3 rounded p-4 position-fixed" style="left:0">
            @include('partials.events.search')
        </div>


        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 p-4">
            <div class="d-flex flex-row mb-4 align-items-center gap-4">
                <h2>Browse Events</h2>
                <a href="{{ route('createEvent') }}">
                    <button type="button" class="btn btn-custom">Create Event</button>
                </a>
            </div>
            <div class="d-flex flex-wrap justify-content-stretch w-100 gap-4 mt-4">
                @if ($events->isEmpty())
                    <p>No events were found</p>
                @else
                    @foreach ($events as $event)
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 d-flex flex-column flex-grow-1">
                            @include('partials.events.verticalCard', ['event' => $event, 'display_tags' => true])
                        </div>
                    @endforeach
                @endif
            </div>
            @if ($events->links()->paginator->hasPages())
                <div class="mt-4">
                    {!! $events->links() !!}
                </div>
            @endif
        </div>
    @endsection
</div>
