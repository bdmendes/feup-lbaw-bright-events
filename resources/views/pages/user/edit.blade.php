@extends('layouts.app')

@section('title', 'home')

@section('content')
<div class="container-fluid w-75 bg-dark mt-1 text-light">
        <div class="row">
            <div class="col-auto col-6 d- p-3">
                    <h1>Edit User Profile</h1>
                    <form method="POST" action="{{ route('editUser', ['username' => Auth::user()->username]) }}">
                        @csrf

                        <label for="name">Name</label>
                        <input class="text-white" type="text" name="name" id="name" value="{{Auth::user()->name}}" placeholder="Name">
                        @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                        @endif

                        <label for="username">Username</label>
                        <input class="text-white" type="text" name="username" id="username" value="{{Auth::user()->username}}" placeholder="Username">
                        @if ($errors->has('username'))
                        <span class="error">
                            {{ $errors->first('username') }}
                        </span>
                        @endif

                        <label for="bio">Bio</label>
                        <textarea class="text-white" type="text" name="bio" id="bio" value="{{Auth::user()->bio}}" placeholder="Bio"></textarea>
                        @if ($errors->has('bio'))
                        <span class="error">
                            {{ $errors->first('bio') }}
                        </span>
                        @endif

                        <label for="email">Email</label>
                        <input class="text-white" type="text" name="email" id="email" value="{{Auth::user()->email}}" placeholder="Email">
                        @if ($errors->has('email'))
                        <span class="error">
                            {{ $errors->first('email') }}
                        </span>
                        @endif

                        <label for="birth_date">Birth Date</label>
                        <input class="text-dark d-block" type="date" name="birth_date" id="birth_date" value="{{Auth::user()->birth_date}}" placeholder="birth_date">
                        @if ($errors->has('birth_date'))
                        <span class="error">
                            {{ $errors->first('birth_date') }}
                        </span>
                        @endif

                        <label for="gender">Gender</label>
                        <select name="gender" name="gender" id="gender" class="text-white">
                            <option value="Female" @if (!is_null(Auth::user()->gender) && Auth::user()->gender == "Female")
                                 selected 
                                 @endif>Female</option>
                            <option value="Male" @if (!is_null(Auth::user()->gender) && Auth::user()->gender == "Male")
                                 selected 
                                 @endif>Male</option>
                            <option value="Other" @if (!is_null(Auth::user()->gender) && Auth::user()->gender == "Other") 
                                selected 
                                @endif>Other</option>
                        </select>

                        <label for="password">Password</label>
                        <input class="text-white" type="password" name="password" id="password" placeholder="Password">
                        @if ($errors->has('password'))
                        <span class="error">
                            {{ $errors->first('password') }}
                        </span>
                        @endif

                        <label for="confirm-password">Confirm password</label>
                        <input class="text-white" type="password" name="confirm-password" id="confirm-password" placeholder="Confirm password">

                        <button type="submit" class="btn-light">
                            Submit
                        </button>
                    </form>
                </div>
            <div class="col-auto col-6 p-3 d-flex align-items-center justify-content-center">
                @if(is_null($user->profile_picture_id))
                    <img src="https://cdn.pixabay.com/photo/2017/08/10/02/05/tiles-shapes-2617112_960_720.jpg" alt="Generic Profile Picture" class="mb-3 rounded-circle align-self-left" style="object-fit: cover; width: 300px; height: 300px;">
                @else
                    <img src="{{$user->profile_picture_id}}" alt="{{$user->name}}'s Profile Picture">
                @endif
            </div>
        </div>
    </div>
@endsection
