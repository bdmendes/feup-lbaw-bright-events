@extends('layouts.app')

@section('title', 'events')

@section('content')
    <div class="d-flex row gap-4">
        <div class="col-3 border rounded py-2">

            <h3 class="mb-3">Search</h3>
            <div class="form-group border-bottom mb-5">
                <div class="input-group">
                    <input style="font-size: 1em; border: none;" name="search" class="form-control"
                        placeholder="Enter a keyword">
                    <span><button class="btn btn-outline-light" style="border:none; " type="submit"><i class="bi bi-search"
                                style="color: black;"></i></button></span>
                </div>
            </div>

            <h3 class="mb-3">Filter</h3>
            <div class="mb-5 d-flex row gap-3">
                <div data-bs-toggle="collapse" href="#filter-date">Date <i class="bi bi-chevron-down"></i></a>
                </div>
                <div class="mb-4 collapse" id="filter-date">
                    a date
                </div>

                <div data-bs-toggle="collapse" href="#filter-location">Location <i class="bi bi-chevron-down"></i></a>
                </div>
                <div class="mb-4 collapse" id="filter-location">
                    a location
                </div>

                <div data-bs-toggle="collapse" href="#filter-organizer">Organizer <i class="bi bi-chevron-down"></i></a>
                </div>
                <div class="mb-4 collapse" id="filter-organizer">
                    an organizer
                </div>

                <div data-bs-toggle="collapse" href="#filter-tag">Tag <i class="bi bi-chevron-down"></i></a>
                </div>
                <div class="mb-4 collapse" id="filter-tag">
                    a tag
                </div>
            </div>

            <h3 class="mb-3">Order By</h3>
            <div class="mb-5 d-flex row gap-3">
                <div>
                    Popularity
                    <i class="bi bi-arrow-up" style="color: black;"></i>
                    <i class="bi bi-arrow-down" style="color: black;"></i>
                </div>
                <div>
                    Date
                    <i class="bi bi-arrow-up" style="color: black;"></i>
                    <i class="bi bi-arrow-down" style="color: black;"></i>
                </div>
            </div>

        </div>

        <div class="col">
            <h2>Browse Events</h2>
            @foreach ($events as $event)
                <div class="mt-4">
                    @include('partials.eventcard', ['event' => $event])
                </div>
            @endforeach
        </div>
    </div>
@endsection
