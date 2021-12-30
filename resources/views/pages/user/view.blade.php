@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container-fluid w-75 bg-dark mt-1 text-light">
        <div class="row">
            <div class="col-auto d-flex flex-row p-3 w-100">
                @if(is_null($user->profile_picture_id))
                    <img src="https://cdn.pixabay.com/photo/2017/08/10/02/05/tiles-shapes-2617112_960_720.jpg" alt="Generic Profile Picture" class="mb-3 rounded-circle align-self-left" style="object-fit: cover; width: 300px; height: 300px;">
                @else
                    <img src="{{$user->profile_picture_id}}" alt="{{$user->name}}'s Profile Picture">
                @endif
                <div class="info w-100 px-3">
                    <span class="d-inline-flex align-items-center justify-content-between w-100">
                        <h1>{{$user->name}}</h1>
                        @if (Auth::check())
                            @if (Auth::user()->id == $user->id)
                                <a href="{{route('editProfile', ['id' => Auth::user()->id])}}" class="text-white">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            @endif
                        @endif
                    </span>
                    <h3>{{$user->username}}</h3>
                    @if (!is_null($user->bio))
                        <p>{{$user->bio}}</p>
                    @endif
                </div>
            </div>
            <div class="col-auto w-100">
                @include('partials.user.tabview')
            </div>
        </div>
    </div>
@endsection
