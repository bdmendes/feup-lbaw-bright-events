@extends('layouts.app')

@section('title', 'users')

@section('content')
    <div class="inline-block">
        <h2>Browse Users</h2>
        <form action="{{ route('browseUsers') }}" method="GET">
            <div class="mt-4 form-group border-bottom mb-5">
                <div class="input-group">
                    <input style="font-size: 1em; border: none;" type="text" name="global"
                        value="{{ $request->global ?? '' }}" autocomplete="off" name="search" class="form-control"
                        placeholder="Enter a keyword">
                    <span><button class="btn btn-outline-light" style="border:none; " type="submit"><i class="bi bi-search"
                                style="color: black;"></i></button></span>
                </div>
        </form>
    </div>

    @if ($users->isEmpty())
        No users were found
    @else
        <div class="row gap-4">
            @foreach ($users as $user)
                @include('partials.users.card', compact('user'))
            @endforeach
        </div>
    @endif
    @if ($users->links()->paginator->hasPages())
        <div class="mt-4">
            {!! $users->links() !!}
        </div>
    @endif
@endsection
