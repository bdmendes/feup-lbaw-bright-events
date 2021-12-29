@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container-fluid w-75 bg-dark mt-1 text-light">
        <div class="row">
            <div class="col-auto d-flex flex-column p-3">
                @if(is_null($user->profile_picture_id))
                    <img src="https://cdn.pixabay.com/photo/2017/08/10/02/05/tiles-shapes-2617112_960_720.jpg" alt="Generic Profile Picture" class="mb-3 rounded-circle align-self-center" style="object-fit: cover; width: 300px; height: 300px;">
                @else
                    <img src="{{$user->profile_picture_id}}" alt="{{$user->name}}'s Profile Picture">
                @endif
                <h1>{{$user->name}}</h1>
                <h3>{{$user->username}}</h3>
            </div>
            <div class="col-auto">
                @include('partials.user.tabview')
            </div>
        </div>
    </div>
@endsection