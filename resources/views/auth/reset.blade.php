@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    {{-- <script type="text/javascript" src={{ asset('js/auth.js') }} defer></script> --}}
@endsection

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-6 d-flex flex-column justify-content-center align-items-center" id="register-col">
            <form method="POST" action="{{ route('password.reset') }}"
                class="d-flex flex-column col-lg-6 col-md-8 col-sm-10 gap-4">
                {{ csrf_field() }}

                <h1>Set up new password</h1>

                <input class="input" onchange="removeErrors('email');" id="email" type="email" name="email"
                    value="{{ old('email') }}" placeholder="Email" required>
                @if ($errors->has('email'))
                    <span class="error" id="emailError">
                        {{ $errors->first('email') }}
                    </span>
                @endif

                <input class="input" id="password" type="password" name="password" placeholder="New password"
                    required>

                <input class="input" id="password_confirmation" type="password" name="password_confirmation"
                    placeholder="Confirm your new password" required>

                <input class="input" id="token" name="token" value="{{ $token }}" hidden>

                <button type="submit" class="btn btn-custom">
                    Submit
                </button>

                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                @if (Session::has('errors'))
                    <div class="alert alert-danger">{{ Session::get('errors') }}</div>
                @endif
            </form>
        </div>
        <div id="thumbnail" class="d-none d-xl-block col-xl-6 bg-dark">
            <img src="/images/auth/recover.jpg" alt="">
        </div>
    </div>


@endsection
