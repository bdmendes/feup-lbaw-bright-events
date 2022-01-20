@extends('layouts.app')

@section ('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section ('scripts')
    <script type="text/javascript" src={{ asset('js/auth.js') }} defer></script>
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-6 d-flex flex-column justify-content-center align-items-center" id="edit-col">
        <form method="POST" action="{{ route('register') }}" class="d-flex flex-column col-lg-6 col-md-8 col-sm-10 gap-4">
            {{ csrf_field() }}

            <h1>Register</h1>

            <input class="input" onchange="removeErrors('name');" id="name" type="text" name="name" value="{{ old('name') }}" placeholder = "Name" required autofocus>
            @if ($errors->has('name'))
            <span class="error" id="nameError">
                {{ $errors->first('name') }}
            </span>
            @endif

            <input class="input" onchange="removeErrors('username');" id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
            @if ($errors->has('username'))
            <span class="error" id="usernameError">
                {{ $errors->first('username') }}
            </span>
            @endif

            <input class="input" onchange="removeErrors('email');" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required>
            @if ($errors->has('email'))
            <span class="error" id="emailError">
                {{ $errors->first('email') }}
            </span>
            @endif

            <input class="input" onchange="removeErrors('password');" id="password" type="password" name="password" placeholder="Password" required>
            @if ($errors->has('password'))
            <span class="error" id="passwordError">
                {{ $errors->first('password') }}
            </span>
            @endif

            <input class="input" id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm your password" required >

            <select class="input" name="gender" name="gender" id="gender" required>
                <option value="" selected disabled><span class="text-muted">Gender</span></option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Other">Other</option>
            </select>

            <button type="submit" class="btn btn-custom">
            Register
            </button>

            <hr class="m-0">

            <p class="not-registered">
                Already registered?
                <a class="register-link" href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>
    <div id="thumbnail" class="d-none d-xl-block col-xl-6 bg-dark">
        <img src="/images/auth/register.jpg" alt="">
    </div>
</div>


@endsection
