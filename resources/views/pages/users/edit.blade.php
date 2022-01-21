@extends('layouts.app')

@section('title', 'home')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script type="text/javascript" src={{ asset('js/auth.js') }} defer></script>
@endsection

@section('content')
    @include('layouts.breadcrumbs',
    ['pages'=>[['name' => 'Home', 'route'=> route('home')],
    ['name' => 'Users','route'=>route('browseUsers')],
    ['name' => $user->username, 'route'=>route('profile', ['username' => $user->username])],
    ['name' => 'Edit Profile', 'route' => route('editProfile', ['username' => $user->username])]]])

    <div class="d-flex justify-content-center">
        <div id="thumbnail" class="d-none d-xl-block col-xl-6 bg-dark">
            <img src="/images/auth/edit.jpg" alt="">
        </div>
        <div class="col-6 d-flex flex-column justify-content-center align-items-center m-4" id="login-col">
            <form class="d-flex flex-column col-lg-6 col-md-8 col-sm-10 gap-4" method="POST" enctype="multipart/form-data"
                action="{{ route('editUser', ['username' => $user->username]) }}">
                @csrf

                <h1>Edit User Profile</h1>

                <input class="input" onchange="removeErrors('name');" class="text-white mb-3" type="text" name="name"
                    id="name" value="{{ $user->name }}" placeholder="Name">
                @if ($errors->has('name'))
                    <span class="error" id="nameError">
                        {{ $errors->first('name') }}
                    </span>
                @endif

                <input class="input" onchange="removeErrors('username');" class="text-white mb-3" type="text"
                    name="username" id="username" value="{{ $user->username }}" placeholder="Username">
                @if ($errors->has('username'))
                    <span class="error" id="usernameError">
                        {{ $errors->first('username') }}
                    </span>
                @endif

                <textarea class="input" onchange="removeErrors('bio');" class="text-white" type="text"
                    name="bio" id="bio" value="{{ $user->bio }}" placeholder="Bio">{{ $user->bio }}</textarea>
                @if ($errors->has('bio'))
                    <span class="error" id="bioError">
                        {{ $errors->first('bio') }}
                    </span>
                @endif

                <input class="input" onchange="removeErrors('email');" class="text-white mb-3" type="text"
                    name="email" id="email" value="{{ $user->email }}" placeholder="Email">
                @if ($errors->has('email'))
                    <span class="error" id="emailError">
                        {{ $errors->first('email') }}
                    </span>
                @endif

                <input class="input" onchange="removeErrors('birth_date');" class="text-dark mb-3 d-block"
                    type="date" name="birth_date" id="birth_date" value="{{ $user->birth_date }}"
                    placeholder="birth_date">
                @if ($errors->has('birth_date'))
                    <span class="error" id="birth_dateError">
                        {{ $errors->first('birth_date') }}
                    </span>
                @endif

                <select class="input" name="gender" name="gender" id="gender" class="mb-3">
                    <option value="Female" @if (!is_null($user->gender) && $user->gender == 'Female')
                        selected
                        @endif>Female</option>
                    <option value="Male" @if (!is_null($user->gender) && $user->gender == 'Male')
                        selected
                        @endif>Male</option>
                    <option value="Other" @if (!is_null($user->gender) && $user->gender == 'Other')
                        selected
                        @endif>Other</option>
                </select>

                <input class="input" onchange="removeErrors('password');" class="text-white mb-3" type="password"
                    name="password" id="password" placeholder="Password">
                @if ($errors->has('password'))
                    <span class="error" id="passwordError">
                        {{ $errors->first('password') }}
                    </span>
                @endif

                <input class="input" onchange="removeErrors('confirm_password');" class="text-white mb-3"
                    type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password">

                <h4 class="m-0">Upload a new profile picture:</h4>
                <input class="input" class="text-white mb-3" type="file" name="profile_picture"
                    id="profile_picture" placeholder="Crisóstomo">

                <input class="input" type="hidden" name="id" id="id" value="{{ $user->id }}">
                <button type="submit" class="btn btn-custom">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection
