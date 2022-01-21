@extends('layouts.app')

@section('title', 'home')

@include('layouts.breadcrumbs', ['pages'=>[['name' => 'Home', 'route'=> route('home')],['name' => 'About us',
'route'=>route('about')]]])

@section('content')
    An events site.
@endsection
