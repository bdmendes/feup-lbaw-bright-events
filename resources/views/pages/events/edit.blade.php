@extends('layouts.app')

@section('title', 'home')

@section('content')

    <form action="{{ route('createEvent')}}" method="post">
        @csrf
        <div class="d-flex align-items-lg-center flex-column mx-auto col-lg-6 col-md-8 col-sm-10 col-12 p-1 pb-3"
        style="background-color: #91A0AD !important;">
            <div class="p-1 w-100">
                <h1>Event creation</h1>
            </div>

            <!--
            <div class="p-3 w-100">
                    is_private[required], date[required], event_state[required], cover_image_id, location_id
            </div>
            -->
            <!-- Event title -->
            <div class="p-3 w-100">
                <label class="w-100"> Event title:</label>
                <input id="title" name="title" placeholder="Insert event title"/>
            </div>

            <div class="p-3 w-100 content-float">
                <!-- Event date -->
                <div class="col-lg-6 col-sm-12 col-12 mb-2">
                    <label class="w-100" > Event date: </label>
                    <input type="date" name="date" id="date"> </input>
                </div>
                <!-- Is private -->
                <div class="col-lg-6 col-sm-12 col-12 mb-2">
                    <label class="p-2 w-100"> Event restriction </label>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="restriction" id="restriction1" autocomplete="off" value="public" checked>
                        <label class="btn btn-outline-primary" for="restriction1">Public</label>

                        <input type="radio" class="btn-check" name="restriction" id="restriction2" autocomplete="off" value="private">
                        <label class="btn btn-outline-primary" for="restriction2">Private</label>
                    </div>
                </div>
            </div>



            <!-- Tags -->
            <div class="p-3 w-100 content-float">
                <div class="col-lg-6 col-sm-12 col-12 mb-2 ">
                    <label class="p-2 w-100"> Tags </label>
                    <div id="tagsDiv" class="w-100 d-flex justify-content-start flex-wrap">
                        <span class="tag m-1 hidden"> </span>
                        @if($event ?? '' ?? '')
                            @foreach ($event ?? ''->tags as $tag)
                                <span class="tag m-1"> {{$tag->name}}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-12">
                    <label class="p-2 w-100"> Add tags </label>
                    <input list="tagOptions"
                        id="tag"
                        placeholder="Search tag...">
                    <datalist id="tagOptions">
                        @foreach($tags as $tag)
                            <option data-value="{{$tag->id}}" value="{{$tag->name}}" > </option>
                        @endforeach
                    </datalist>
                    <button type="button" onclick="addItem('tagsDiv', 'tag', 'tags'); clearValue('tag');"> Add </button>
                </div>
            </div>



            <!-- Description -->
            <div class="p-3 w-100">
                <label class="p-2 w-100"> Description </label>
                <textarea id="description" name="description" placeholder="Insert description"> </textarea>
            </div>

            <button type="submit"> Create </button>

        </div>
    <form>
@endsection
