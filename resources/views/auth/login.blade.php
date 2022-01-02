@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <label class="d-block" for="email">E-mail</label>
    <input onchange="removeErrors('email');" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error" id="emailError">
          {{ $errors->first('email') }}
        </span>
    @endif

    <label class="d-block" for="password" >Password</label>
    <input onchange="removeErrors('password');" id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error" id="passwordError">
            {{ $errors->first('password') }}
        </span>
    @endif

    <label class="d-block">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>

    <button type="submit">
        Login
    </button>
    <a class="button button-outline" href="{{ route('register') }}">Register</a>
</form>
@endsection
