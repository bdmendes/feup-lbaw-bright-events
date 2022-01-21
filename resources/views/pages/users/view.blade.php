@extends('layouts.app')

@section('title', 'home')

@section ('styles')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@endsection

@section ('scripts')
    <script type="text/javascript" src={{ asset('js/profile.js') }} defer></script>
@endsection

@section('content')
<div id="small-user-banner" class="col-12 d-xs-flex d-sm-flex d-md-flex d-lg-flex d-xl-none justify-content-center p-4">
    <div class="row w-100 p-0">
        @include('partials.users.smallProfileInfo', compact('user'))
    </div>
</div>
<div class="d-flex justify-content-end p-4 mx-4">
    <div class="d-none col-xl-3 d-xl-flex flex-column align-items-center p-4 gap-4 border" style="left:0;" id="user-banner">
        @include('partials.users.profileInfo', compact('user'))
    </div>


    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 px-4" id="user-tabs">
        <ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                @if (Auth::check() && Auth::user()->id == $user->id)
                    <button class="nav-link active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">My Events</button>
                @else
                    <button class="nav-link active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Organized
                        Events</button>
                @endif
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="attendances-tab" data-bs-toggle="tab"
                    data-bs-target="#attendances" type="button" role="tab" aria-controls="contact"
                    aria-selected="false">Attendances</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="contact-tab">
                <div class="w-100 p-4">
                    @forelse ($user->events()->where('is_disabled', 'false')->get() as $event)
                        @include('partials.events.card', compact('event'))
                    @empty
                        <p class="text-grey disabled">Nothing to see here</p>
                    @endforelse
                </div>
            </div>
            <div class="tab-pane fade" id="attendances" role="tabpanel" aria-labelledby="contact-tab">
                <div class="w-100 p-4">
                    @forelse ($attended_events as $event)
                        @include('partials.events.card', compact('event'))
                    @empty
                        <p class="text-grey disabled">Nothing to see here</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection
