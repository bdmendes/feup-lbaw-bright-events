@extends('layouts.app')

@section('title', 'events')

@section('content')
    @foreach ($events as $event)
        @include('partials.eventcard', ['event' => $event])
    @endforeach
@endsection
