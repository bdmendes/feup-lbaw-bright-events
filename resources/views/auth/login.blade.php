@extends('layouts.app')

@section ('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section ('scripts')
    <script type="text/javascript" src={{ asset('js/auth.js') }} defer></script>
@endsection

@section('content')
<div class="d-flex justify-content-center">
    <div class="col-6 d-flex flex-column justify-content-center align-items-center" id="login-col">
        <form method="POST" action="{{ route('login') }}" class="d-flex flex-column col-lg-6 col-md-8 col-sm-10 gap-4">
            {{ csrf_field() }}

            <h1>Login</h1>
            
            <input class="input" onchange="removeErrors('email');" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email or username" required autofocus>
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

            <label class="d-block">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            </label>

            <button class="btn btn-custom" type="submit">
                Login
            </button>

            <hr class="m-0">
            <p class="not-registered">
                Not registered yet?
                <a class="register-link" href="{{ route('register') }}">Register now!</a>
            </p>
        </form>
    </div>
    <div id="thumbnail" class="d-none d-xl-block col-xl-6 bg-dark">
        <img src="/images/auth/login.jpg" alt="">
    </div>
</div>
@endsection
