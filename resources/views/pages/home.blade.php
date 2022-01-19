@extends('layouts.app')

@section('title', 'home')

@section ('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section ('scripts')
    <script type="text/javascript" src={{ asset('js/home.js') }} defer></script>
@endsection

@section('content')

    <div id="banner" class="carousel slide w-100 position-fixed" data-bs-ride="carousel" data-bs-interval="4000" data-bs-wrap="true" data-bs-pause="false">
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
        <img class="d-block w-100 banner" src="/images/banner/park.jpg" alt="First slide">

        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>

      <div class="carousel-item">
        <img class="d-block w-100 banner" src="/images/banner/concert.jpg" alt="First slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <img class="d-block w-100 banner" src="/images/banner/children.jpg" alt="First slide">
        <div class="container">
          <div class="carousel-caption">
            <h1>Bright events for a bright community</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

    <br>

    <div id="trends" class="bg-light py-5">
        <div class="container">
            <div class="row trending">
                <div class="col-md-6 d-flex flex-column justify-content-center">
                    <h2 class="trending-header">Trending Events. <span class="text-muted">What everybody is talking about.</span></h2>
                    <p class="trending-body">These are the events that have everybody's heads spinning. Will you miss out on them? Check them out before it's too late.</p>
                    <div>
                        <a href="{{ route('browseEvents') }}"><button type="button" class="btn btn-primary btn"
                                style="font-size: 1em;">See more</button></a>
                        <a href="{{ route('createEvent') }}"><button type="button" class="btn btn-primary btn"
                                style="font-size: 1em;">Create Event</button></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="events-carousel" class="carousel carousel-fade slide w-100" data-bs-ride="carousel" data-bs-interval="4000" data-bs-wrap="true" data-bs-pause="false">
                        <div class="carousel-inner mx-5" id="events-carousel-inner">
                            @foreach ($events as $event)
                                <div class="carousel-item">
                                    @include('partials.events.verticalCard', ['event' => $event])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <hr>
            <br>
            
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
    </div>
@endsection
