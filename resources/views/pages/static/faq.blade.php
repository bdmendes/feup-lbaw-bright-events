@extends('layouts.app')

@section('title', 'home')

@include('layouts.breadcrumbs', ['pages'=>[['name' => 'Home', 'route'=> route('home')],['name' => 'FAQ',
'route'=>route('faq')]]])

@section('content')
    FAQ
@endsection
