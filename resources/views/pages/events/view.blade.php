@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="d-flex align-items-lg-center flex-column mx-auto col-lg-6 col-md-8 col-sm-10 col-xs-12 p-1">
        @include('partials.event', ['event' => $event])
    </div>
@endsection
