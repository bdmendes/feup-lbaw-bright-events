@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container-fluid w-75 bg-dark mt-1 text-light">
        <div class="row">
            <div class="col-auto col-6 d- p-3">
                <h1>Edit User Profile</h1>
                <form method="POST" enctype="multipart/form-data" action="{{ route('editUser', ['username' => $user->username]) }}">
                    @csrf

                    <label class="d-block" for="name">Name</label>
                    <input onchange="removeErrors('name');" class="text-white mb-3" type="text" name="name" id="name" value="{{ $user->name }}"
                        placeholder="Name">
                    @if ($errors->has('name'))
                        <span class="error" id="nameError">
                            {{ $errors->first('name') }}
                        </span>
                    @endif

                    <label class="d-block" for="username">Username</label>
                    <input onchange="removeErrors('username');" class="text-white mb-3" type="text" name="username" id="username"
                        value="{{ $user->username }}" placeholder="Username">
                    @if ($errors->has('username'))
                        <span class="error" id="usernameError">
                            {{ $errors->first('username') }}
                        </span>
                    @endif

                    <label class="d-block" for="bio">Bio</label>
                    <textarea onchange="removeErrors('bio');" class="text-white" type="text" name="bio" id="bio" value="{{ $user->bio }}"
                        placeholder="Bio">{{ $user->bio }}</textarea>
                    @if ($errors->has('bio'))
                        <span class="error" id="bioError">
                            {{ $errors->first('bio') }}
                        </span>
                    @endif

                    <label class="d-block" for="email">Email</label>
                    <input onchange="removeErrors('email');" class="text-white mb-3" type="text" name="email" id="email" value="{{ $user->email }}"
                        placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="error" id="emailError">
                            {{ $errors->first('email') }}
                        </span>
                    @endif

                    <label class="d-block" for="birth_date">Birth Date</label>
                    <input onchange="removeErrors('birth_date');" class="text-dark mb-3 d-block" type="date" name="birth_date" id="birth_date"
                        value="{{ $user->birth_date }}" placeholder="birth_date">
                    @if ($errors->has('birth_date'))
                        <span class="error" id="birth_dateError">
                            {{ $errors->first('birth_date') }}
                        </span>
                    @endif

                    <label class="d-block" for="gender">Gender</label>
                    <select name="gender" name="gender" id="gender" class="text-white mb-3">
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

                    <label class="d-block" for="password">Password</label>
                    <input onchange="removeErrors('password');" class="text-white mb-3" type="password" name="password" id="password" placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="error" id="passwordError">
                            {{ $errors->first('password') }}
                        </span>
                    @endif

                    <label class="d-block" for="confirm_password">Confirm password</label>
                    <input onchange="removeErrors('confirm_password');" class="text-white mb-3" type="password" name="confirm_password" id="confirm_password"
                        placeholder="Confirm password">
                    
                    <label class="d-block" for="profile_picture"></label>
                    <input class="text-white mb-3" type="file" name="profile_picture" id="profile_picture">

                    <input type="hidden" name="id" id="id" value="{{$user->id}}">
                    <button type="submit" class="btn-light d-block my-2">
                        Submit
                    </button>
                </form>
            </div>
            <div class="col-auto col-6 p-3 d-flex align-items-center justify-content-center">
                @if (is_null($user->profile_picture_id))
                    <img src="https://cdn.pixabay.com/photo/2017/08/10/02/05/tiles-shapes-2617112_960_720.jpg"
                        alt="Generic Profile Picture" class="mb-3 rounded-circle align-self-left"
                        style="object-fit: cover; width: 300px; height: 300px;">
                @else
                    <img src="/{{ $user->profile_picture->path }}" alt="{{ $user->name }}'s Profile Picture" class="mb-3 rounded-circle align-self-left" style="object-fit: cover; width: 300px; height: 300px;">
                @endif
            </div>
        </div>
    </div>
@endsection
