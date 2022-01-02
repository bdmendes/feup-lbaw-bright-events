@extends('layouts.app')

@section('title', 'events')

@section('content')
    <div class="row gap-4">
        <div class="col-md-3 border rounded py-2">

            <h3 class="mb-3">Search</h3>
            <form action="{{ route('browseEvents') }}" method="GET">
                <div class="form-group border-bottom mb-5">
                    <div class="input-group">
                        <input style="font-size: 1em; border: none;" type="text" name="global"
                            value="{{ $request->global ?? '' }}" autocomplete="off" name="search" class="form-control"
                            placeholder="Enter a keyword">
                        <span><button class="btn btn-outline-light" style="border:none; " type="submit"><i
                                    class="bi bi-search" style="color: black;"></i></button></span>
                    </div>
            </form>
        </div>

        <h3 class="mb-3">Filter</h3>
        <div class="mb-5 row gap-3">
            <div data-bs-toggle="collapse" href="#filter-date">Date <i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="collapse {{ $request->filled('begin_date') || $request->filled('end_date') ? 'show' : '' }}"
                id="filter-date">
                <form method="GET">
                    <div>Begin <input id="date" value="{{ $request->begin_date }}" type="date" name="begin_date"></div>
                    <div>End <input id="date" value="{{ $request->end_date }}" type="date" name="end_date"></div>
                    <input type="submit">
                </form>
            </div>

            <div data-bs-toggle="collapse" href="#filter-organizer">Organizer <i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="collapse {{ $request->filled('organizer') ? 'show' : '' }}" id="filter-organizer">
                <form method="GET">
                    <select name="cars" id="cars" onchange="this.form.submit()">
                        <optgroup label="Swedish Cars">
                            <option value="volvo">Volvo</option>
                            <option selected value="saab">Saab</option>
                        </optgroup>
                        <optgroup label="German Cars">
                            <option value="mercedes">Mercedes</option>
                            <option value="audi">Audi</option>
                        </optgroup>
                    </select>
                </form>
            </div>

            <div data-bs-toggle="collapse" href="#filter-tag">Tag <i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="mb-4 collapse" id="filter-tag">
                a tag
            </div>
        </div>

        <h3 class="mb-3">Order By</h3>
        <div class="mb-5 d-flex row">
            <div>
                Title
                <button
                    onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'title', 'order' => 'ascending']) }}'"
                    type="button"
                    class="{{ $request->query('sort_by') == 'title' && $request->query('order') == 'ascending' ? 'active' : '' }}  btn btn-outline-info"><i
                        class="bi bi-arrow-up" style="color: black;"></i></button>
                <button
                    onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'title', 'order' => 'descending']) }}'"
                    type="button"
                    class="{{ $request->query('sort_by') == 'title' && $request->query('order') == 'descending' ? 'active' : '' }} btn btn-outline-info"><i
                        class="bi bi-arrow-down" style="color: black;"></i></button>
            </div>
            <div>
                Date
                <button
                    onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'date', 'order' => 'ascending']) }}'"
                    type="button"
                    class="{{ $request->query('sort_by') == 'date' && $request->query('order') == 'ascending' ? 'active' : '' }} btn btn-outline-info"><i
                        class="bi bi-arrow-up" style="color: black;"></i></button>
                <button
                    onclick="location.href='{{ $request->fullUrlWithQuery(['sort_by' => 'date', 'order' => 'descending']) }}'"
                    type="button"
                    class="{{ $request->query('sort_by') == 'date' && $request->query('order') == 'descending' ? 'active' : '' }} btn btn-outline-info"><i
                        class="bi bi-arrow-down" style="color: black;"></i></button>
            </div>
        </div>

    </div>

    <div class="col">
        <a href="{{ route('createEvent') }}"> <button type="button" class="btn btn-primary"
                style="float: right; font-size: 1em;">Create Event</button></a>
        <h2 class="mb-4">Browse Events</h2>
        @if ($events->isEmpty())
            No events were found
        @else
            @foreach ($events as $event)
                <div class="mb-4">
                    @include('partials.events.card', ['event' => $event])
                </div>
            @endforeach
        @endif
        @if ($events->links()->paginator->hasPages())
            <div class="mt-4">
                {!! $events->links() !!}
            </div>
        @endif
    </div>
    </div>
@endsection
