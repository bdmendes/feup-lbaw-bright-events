@extends('layouts.app')

@section('title', 'users')

@section('styles')
    <link href="{{ asset('css/users.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('partials.breadcrumbs', ['pages'=>[['name' => 'Home', 'route'=> route('home')],['name' => 'Users',
    'route'=>route('browseUsers')]]])

    <div class="d-flex align-items-center justify-content-center w-100 gap-4 mt-4">
        <h1>Browse Users</h1>
        <form action="{{ route('browseUsers') }}" method="GET" class="mb-0">
            <div class="d-flex flex-nowrap">
                <input type="text" name="global" value="{{ $request->global ?? '' }}" autocomplete="off" name="search"
                    class="input w-75" placeholder="Enter a keyword">
                <span>
                    <button class="btn btn-outline-light" style="border:none; " type="submit">
                        <i class="bi bi-search" style="color: black;"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <div class="d-flex flex-column align-items-center p-4">

        <div class="d-flex justify-content-center flex-wrap w-100 gap-4" id="users">
            @if ($users->isEmpty())
                No users were found
            @else
                @foreach ($users as $user)
                    <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-2 d-flex flex-column user-div">
                        @include('partials.users.card', compact('user'))
                    </div>
                @endforeach
            @endif
        </div>

        @if ($users->links()->paginator->hasPages())
            <div class="mt-4">
                {!! $users->links() !!}
            </div>
        @endif
    </div>

@endsection
