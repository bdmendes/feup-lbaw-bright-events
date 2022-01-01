@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container-fluid w-75 bg-dark mt-1 text-light">
        <div class="row">
            <div class="col-auto d-flex flex-row p-3 w-100">
                @if (is_null($user->profile_picture_id))
                    <img src="https://cdn.pixabay.com/photo/2017/08/10/02/05/tiles-shapes-2617112_960_720.jpg"
                        alt="Generic Profile Picture" class="mb-3 rounded-circle align-self-left"
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
                                @if (Auth::user()->is_admin && !$user->is_admin)
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
                                    <form method="POST" action="{{ route('profile', ['username' => $user->username]) }}"
                                        style="cursor: pointer">
                                        @csrf
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
                                @if (Auth::user()->id == $user->id || Auth::user()->is_admin)
                                    <a href="{{ route('editProfile', ['username' => Auth::user()->username]) }}"
                                        class="text-white m-3 text-decoration-none d-flex flex-column align-items-center">
                                        <i class="bi bi-pencil-square"></i>
                                        <p>Edit</p>
                                    </a>
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
                @include('partials.users.tabview')
            </div>
        </div>
    </div>
@endsection
