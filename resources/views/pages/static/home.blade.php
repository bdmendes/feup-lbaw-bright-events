@extends('layouts.app')

@section('title', 'home')

@section('content')

    <div class="container">
        <img src="https://cdn.pixabay.com/photo/2018/05/10/11/34/concert-3387324_960_720.jpg">
        <div style="position: relative; bottom: 100px; text-align: center;">
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
            <br><br>
            <h2>Trending Users</h2>
            <div class="row gap-4 mt-4">
                @foreach ($users as $user)
                    @include('partials.users.card', compact('user'))
                @endforeach
            </div>
        </div>
    </div>
@endsection
