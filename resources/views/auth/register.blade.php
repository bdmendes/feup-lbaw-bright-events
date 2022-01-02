@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <label class="d-block" for="name">Name</label>
    <input onchange="removeErrors('name');" id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
      <span class="error" id="nameError">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label class="d-block" for="username">Username</label>
    <input onchange="removeErrors('username');" id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
      <span class="error" id="usernameError">
          {{ $errors->first('username') }}
      </span>
    @endif

    <label class="d-block" for="email">E-Mail Address</label>
    <input onchange="removeErrors('email');" id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error" id="emailError">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label class="d-block" for="password">Password</label>
    <input onchange="removeErrors('password');" id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error" id="passwordError">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label class="d-block" for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <label class="d-block" for="gender">Gender</label>
    <select name="gender" name="gender" id="gender" required>
        <option value="" selected disabled></option>
        <option value="Female">Female</option>
        <option value="Male">Male</option>
        <option value="Other">Other</option>
    </select>

    <button type="submit">
      Register
    </button>
    <a class="button button-outline" href="{{ route('login') }}">Login</a>
</form>
@endsection
