@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container-fluid w-75 bg-dark mt-1 text-light">
        <div class="row">
            <div class="col-auto d-flex flex-row p-3 w-100">
                @if (is_null($user->profile_picture_id))
                    <img src="/images/user.png" alt="Generic Profile Picture" class="mb-3 rounded-circle align-self-left"
                        style="object-fit: cover; width: 300px; height: 300px;">
                @else
                    <img src="/{{ $user->profile_picture->path }}" alt="{{ $user->name }}'s Profile Picture"
                        class="mb-3 rounded-circle align-self-left" style="object-fit: cover; width: 300px; height: 300px;">
                @endif
                <div class="info w-100 px-3">
                    <span class="d-inline-flex align-items-center justify-content-between w-100">
                        <div class="d-flex flex-column align-items-left">
                            <h1>{{ $user->name }}</h1>
                            <h3>{{ $user->username }}</h3>
                        </div>
                        <div class="d-flex flex-row">
                            @if (Auth::check())
                                @if ((Auth::user()->is_admin || Auth::user()->id === $user->id) && !$user->is_admin)
                                    @if (Auth::user()->is_admin)
                                        <form method="POST"
                                            action="{{ route('profile', ['username' => $user->username]) }}"
                                            style="cursor: pointer">
                                            @csrf

                                            <input type="hidden" value={{ $user->is_blocked ? 1 : 0 }}
                                                name="is_blocked" />
                                            <a onclick="this.parentNode.submit();"
                                                class="text-white m-3 text-decoration-none d-flex flex-column align-items-center">
                                                @if ($user->is_blocked)
                                                    <i class="bi bi-check-circle"></i>
                                                    <p>Unblock</p>
                                                @else
                                                    <i class="bi bi-dash-circle"></i>
                                                    <p>Block</p>
                                                @endif
                                            </a>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('profile', ['username' => $user->username]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <a onclick="this.parentNode.submit();"
                                            class="text-white m-3 text-decoration-none d-flex flex-column align-items-center"
                                            style="cursor: pointer">
                                            <i class="bi bi-trash"></i>
                                            <p>Remove</p>
                                        </a>
                                    </form>
                                    @if (Auth::user()->id === $user->id)
                                        <a href="{{ route('editProfile', ['username' => Auth::user()->username]) }}"
                                            class="text-white m-3 text-decoration-none d-flex flex-column align-items-center">
                                            <i class="bi bi-pencil-square"></i>
                                            <p>Edit</p>
                                        </a>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </span>
                    @if (!is_null($user->bio))
                        <p>{{ $user->bio }}</p>
                    @endif
                </div>
            </div>
            <div class="col-auto w-100">
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

                <style>
                    .nav-item .active {
                        border-color: blue !important;
                        color: white !important;
                        background-color: transparent !important;
                        border-top: 0 !important;
                        border-left: 0 !important;
                        border-right: 0 !important;
                        border-top-color: transparent !important;
                        border-left-color: transparent !important;
                        border-right-color: transparent !important;
                    }

                    .nav-link:hover {
                        border-top-color: transparent !important;
                        border-left-color: transparent !important;
                        border-right-color: transparent !important;
                    }

                </style>
            </div>
        </div>
        @if (Auth::check() && Auth::id() != $user->id)
            <div class="text-end pe-5">
                <span class="link-primary" style="font-size: 0.9em;" type="button"
                    onclick="getReportModal('user', {{ $user->id }});">Report
                    user</span>
            </div>
        @endif
    </div>
    <script type="text/javascript" src={{ asset('js/report.form.js') }} defer></script>
@endsection
