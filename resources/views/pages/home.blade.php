@extends('layouts.app')

@section('title', 'home')

@section('content')

    <div>
        <img class="d-block"
            src="https://pixabay.com/get/gc5f555671439461f5374a79b68f0111c570ca8587d26ab868900b6be1cc5842c778cb6d2dc57dcb9da99bc3ff9ddbaa792150aea646b3a15b1ea6821872a446b299a58e3251c1daabbb855c06873aa56_1920.jpg"
            style="margin: 0 auto; width: 100%; max-height: 400px; object-fit: cover;">
        <div style=" position: relative; bottom: 100px; text-align: center;">
            <h1 class="text-white">A bright community for bright experiences</h1>
        </div>
    </div>

    <br>

    <div>
        <div>
            <h2>Trending Events</h2>
            @foreach ($events as $event)
                <div class="mt-4">
                    @include('partials.events.card', ['event' => $event])
                </div>
            @endforeach
            <div>
                <a href="{{ route('browseEvents') }}"><button type="button" class="btn btn-primary btn"
                        style="font-size: 1em;">See more</button></a>
                <a href="{{ route('createEvent') }}"><button type="button" class="btn btn-primary btn"
                        style="font-size: 1em;">Create Event</button></a>
            </div>
            <br><br>
            <h2>Trending Users</h2>
            <div class="row gap-4 my-4">
                @foreach ($users as $user)
                    @include('partials.users.card', compact('user'))
                @endforeach
            </div>
            <div>
                <a href="{{ route('browseUsers') }}"><button type="button" class="btn btn-primary btn"
                        style="font-size: 1em;">Explore users</button></a>
            </div>
        </div>
    </div>
@endsection
