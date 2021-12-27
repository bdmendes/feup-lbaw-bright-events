@extends('layouts.app')

@section('title', 'home')

@section('content')
    <form action="{{ route('createEvent')}}" method="post">
        <div class="d-flex align-items-lg-center flex-column mx-auto col-lg-6 col-md-8 col-sm-10 col-xs-12 p-1 pb-3"
        style="background-color: #91A0AD !important;">
        <div class="p-1 w-100">
            <h1>Event creation</h1>
        </div>

            <div class="p-3 w-100">
                <label class="p-2  w-100"> Event title:</label>
                <input id="title" name="title" placeholder="Insert event title"/>
            </div>

            <div class="p-3 w-100">
                <label class="p-2 w-100" > Event date: </label>
                See later
            </div>

            <div class="p-3 w-100">
                <label class="p-2 w-100"> Description </label>
                <textarea id="description" name="description" placeholder="Insert description"> </textarea>
            </div>

            <button type="submit"> Create </button>

        </div>
    <form>
@endsection
