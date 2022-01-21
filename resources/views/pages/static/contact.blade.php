@extends('layouts.app')

@section('title', 'home')

@include('layouts.breadcrumbs', ['pages'=>[['name' => 'Home', 'route'=> route('home')],['name' => 'Contacts',
'route'=>route('contacts')]]])

@section('content')
    Contacts
@endsection
