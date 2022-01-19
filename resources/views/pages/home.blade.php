@extends('layouts.app')

@section('title', 'home')

@section ('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section ('scripts')
    <script type="text/javascript" src={{ asset('js/home.js') }} defer></script>
@endsection

@section('content')

    <div id="banner" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000" data-bs-wrap="true" data-bs-pause="false">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100 banner" src="/images/banner/party.jpg" alt="First slide">

        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>

      <div class="carousel-item">
        <img class="d-block w-100 banner" src="/images/banner/cooking.jpg" alt="First slide">

        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>

      <div class="carousel-item">
        <img class="d-block w-100 banner" src="/images/banner/carnival.jpg" alt="First slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100 banner" src="/images/banner/dj.jpg" alt="First slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100 banner" src="/images/banner/guitar.jpg" alt="First slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

    <br>

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
        <h2>Trending Organizers</h2>
        <div class="row gap-4 my-4 w-100">
            @foreach ($users as $user)
                @include('partials.users.card', compact('user'))
            @endforeach
        </div>
        <div>
            <a href="{{ route('browseUsers') }}"><button type="button" class="btn btn-primary btn"
                    style="font-size: 1em;">Explore users</button></a>
        </div>
    </div>
@endsection
