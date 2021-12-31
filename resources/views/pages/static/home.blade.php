@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="homeBackground">
        <img src="https://bomdia.eu/wp-content/uploads/2015/08/estaline.jpg" height="500"> </img>
        <div class="backgroundSlogan">
            <h1>Código ligeiro e compacto</h1>
        </div>
    </div>

    <br>

    <div class="homeContent">
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
