@extends('layouts.app')

@section('title', 'home')

@section('styles')
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script type="text/javascript" src={{ asset('js/home.js') }} defer></script>
@endsection

@section('content')
    <div id="banner" class="carousel carousel-fade slide w-100 position-fixed" data-bs-ride="carousel"
        data-bs-interval="4000" data-bs-wrap="true" data-bs-pause="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 banner" src="/images/banner/party.jpg" alt="First slide">

                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="display-1">Bright events for a bright community</h1>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100 banner" src="/images/banner/park.jpg" alt="First slide">

                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="display-1">Bright events for a bright community</h1>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <img class="d-block w-100 banner" src="/images/banner/concert.jpg" alt="First slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="display-1">Bright events for a bright community</h1>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 banner" src="/images/banner/children.jpg" alt="First slide">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="display-1">Bright events for a bright community</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div id="trends" class="bg-light py-5">
        <div class="container d-flex flex-column justify-content-center">
            <div class="row trending mx-0">
                <div class="col-md-12 col-lg-6 col-xl-6 d-flex flex-column justify-content-center mb-4">
                    <h2 class="trending-header">Trending Events. <span class="text-muted">What everybody is talking
                            about.</span></h2>
                    <p class="trending-body">These are the events that have everybody's heads spinning. Will you miss out
                        on them? Check them out before it's too late.</p>
                    <div>
                        <a href="{{ route('browseEvents') }}"><button type="button" class="btn btn-custom btn">See
                                more</button></a>
                        <a href="{{ route('createEvent') }}"><button type="button" class="btn btn-custom btn">Create
                                Event</button></a>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                    <div id="events-carousel" class="carousel carousel-fade slide w-100" data-bs-ride="carousel"
                        data-bs-interval="4000" data-bs-wrap="true" data-bs-pause="false">
                        <div class="carousel-inner" id="events-carousel-inner">
                            @foreach ($events as $event)
                                <div class="carousel-item">
                                    @include('partials.events.verticalCard', ['event' => $event, 'display_tags' => false])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <hr>
            <br>

            <div class="row trending d-flex flex-column justify-content-center mx-0">
                <div class="row">
                    <h2 class="trending-header">Trending Organizers. <span class="text-muted">The engines behind our
                            vibrant community.</span></h2>
                    <p class="trending-body">See for yourself who are the dynamic people who keep our community engaged.
                    </p>
                </div>
                <div class="d-flex justify-content-center flex-wrap flex-row w-100 gap-4 mt-4 mb-4">
                    @foreach ($users as $user)
                    <div class="d-flex flex-grow-1 flex-wrap col-4 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                            @include('partials.users.homeCard', compact('user'))
                    </div>
                    @endforeach
                </div>
                <div class="w-100 d-flex flex-column align-items-end">
                    <a href="{{ route('browseUsers') }}">
                        <button type="button" class="btn btn-custom btn">
                            See more
                        </button>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
