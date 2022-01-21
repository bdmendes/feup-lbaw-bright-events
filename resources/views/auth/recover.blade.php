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
            <form method="POST" action="{{ route('recoverPassword') }}"
                class="d-flex flex-column col-lg-6 col-md-8 col-sm-10 gap-4">
                {{ csrf_field() }}

                <h1>Recover Password</h1>

                <input class="input" onchange="removeErrors('email');" id="email" type="email" name="email"
                    value="{{ old('email') }}" placeholder="Email" required>
                @if ($errors->has('email'))
                    <span class="error" id="emailError">
                        {{ $errors->first('email') }}
                    </span>
                @endif

                <input class="input" id="email-confirm" type="email" name="email_confirmation"
                    placeholder="Confirm your email" required>

                <button type="submit" class="btn btn-custom">
                    Recover Password
                </button>

                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif

                <hr class="m-0">

                <p class="not-registered">
                    Lost access to your email?
                    <a class="register-link" href="{{ route('register') }}">Create a new account</a>
                </p>
            </form>
        </div>
        <div id="thumbnail" class="d-none d-xl-block col-xl-6 bg-dark">
            <img src="/images/auth/recover.jpg" alt="">
        </div>
    </div>


@endsection
