@extends('layouts.app')

@section('title', 'home')

@section('styles')
    <link href="{{ asset('css/createEvent.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script type="text/javascript" src={{ asset('js/createEvent.js') }} defer></script>
@endsection

@if (empty($event))
    @include('layouts.breadcrumbs', ['pages'=>[['name' => 'Home', 'route'=> route('home')],['name' => 'Events',
    'route'=>route('browseEvents')],['name' => 'Event creation',
    'route'=>route('createEvent')]]])
@else
    @include('layouts.breadcrumbs', ['pages'=>[['name' => 'Home', 'route'=> route('home')],['name' => 'Events',
    'route'=>route('browseEvents')],['name' => $event->title, 'route'=>route('event', ['id' => $event->id])],['name' =>
    'Edit event',
    'route'=>route('editEvent', ['id' => $event->id])]]])
@endif

@section('content')
    <form id="eventCE" action="{{ empty($event) ? route('createEvent') : route('editEvent', [$event->id]) }}"
        enctype="multipart/form-data" method="post" class="d-flex justify-content-start mb-0">
        @csrf

        <div id="form-content" class="h-100 col-6 p-4 gap-4 d-flex flex-column">
            <div class="w-100 p-1">
                @if (empty($event))
                    <h2>Event creation</h2>
                @else
                    <h2>Edit event</h2>
                @endif
            </div>

            <form id="eventCE" action="{{ empty($event) ? route('createEvent') : route('editEvent', [$event->id]) }}"
                enctype="multipart/form-data" method="post">
                @csrf
                @if (!empty($event))
                    <input type="hidden" name="id" id="id" value="{{ $event->id }}" />
                @endif
                <div class="event-form w-100 d-flex flex-column border rounded p-3 gap-3">
                    <h3>Event fundamentals. <span class="text-muted">What everyone should know.</span></h3>
                    <div class="col-lg-6 col-12">
                        <h4>Event Title:</h4>
                        <input class="input" id="title" type="text" name="title"
                            class="col-lg-8 col-12
                        @if ($errors->has('title')) errorBorder @endif"
                            onchange="removeErrors('title');" placeholder="Insert event title"
                            value="{{ empty($event) ? old('title') : $event->title }}" />

                        @if ($errors->has('title'))
                            <span id="titleError" class="error">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>
                    <div class="col-lg-6 col-12">
                        <h4>Event Date:</h4>
                        <input class="input" type="datetime-local" name="date" id="date"
                            onchange="removeErrors('date');"
                            value="{{ empty($event) ? old('date') : $event->date->format('Y-m-d\TH:i') }}"
                            class="@if ($errors->has('date')) errorBorder @endif" />

                        @if ($errors->has('date'))
                            <span id="dateError" class="error">
                                {{ $errors->first('date') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-12 col-12">
                        <h4>Description:</h4>
                        <textarea id="description" name="description" placeholder="Insert description"
                            class=" @if ($errors->has('description')) errorBorder @endif"
                            onchange="removeErrors('description');">{{ empty($event) ? old('description') : $event->description }}</textarea>
                        @if ($errors->has('description'))
                            <span id="descriptionError" class="error">
                                {{ $errors->first('description') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="event-form w-100 d-flex flex-column border rounded p-3 gap-3">
                    <h3>Location.<span class="text-muted"> Where the action will unfold.</span></h3>
                    <div class="d-flex gap-4 align-items-center justify-content-center">
                        <input class="input" class="input" type="text" id="mapGlobalFilter" name="body"
                            placeholder="Introduce a location...">
                        <button id="submit_comment_button" class="btn btn-custom" type="button"
                            onclick="searchMap();">Submit</button>
                    </div>

                    <input class="input" id="lat" name="lat" type="hidden"
                        value="{{ empty($event) ? old('lat') : $event->location->lat }}" />
                    <input class="input" id="long" name="long" type="hidden"
                        value="{{ empty($event) ? old('long') : $event->location->long }}" />

                    <div class="d-flex flex-column">
                        <h4>City:</h4>
                        <input class="input" id="city" name="city" type="text" class="transparent"
                            value="{{ empty($event) ? old('city') : $event->location->city }}" />
                    </div>

                    <div class="d-flex flex-column">
                        <h4>Country:</h4>
                        <input class="input" id="country" name="country" type="text" class="transparent"
                            readonly="readonly"
                            value="{{ empty($event) ? old('country') : $event->location->country }}" />
                    </div>

                    <div class="d-flex flex-column">
                        <h4>Display name:</h4>
                        <input class="input" id="display_name" name="display_name" type="text"
                            class="transparent"
                            value="{{ empty($event) ? old('display_name') : $event->location->display_name }}" />
                    </div>

                    <div class="d-flex flex-column">
                        <h4>Post-code:</h4>
                        <input class="input" id="postcode" name="postcode" type="text" class="transparent"
                            readonly="readonly"
                            value="{{ empty($event) ? old('postcode') : $event->location->postcode }}" />
                    </div>

                    @if (!empty($event))
                        <input class="input" type="hidden" name="id" id="id" value="{{ $event->id }}" />
                    @endif
                </div>

                <div class="event-form w-100 d-flex flex-column border rounded p-3 gap-3">
                    <h3>Optionals. <span class="text-muted">For all the fine-tuning you need.</span></h3>
                    <div class="col-lg-6 col-12">
                        <h4>Cover Image:</h4>
                        <input class="input" id="cover_image" name="cover_image" type="file" class="w-100"
                            onchange="remove('cover_imageError');" />
                        @if ($errors->has('cover_image'))
                            <span id="cover_imageError" class="error">
                                {{ $errors->first('cover_image') }}
                            </span>
                        @endif
                    </div>

                    <div class="col-lg-6 col-12">
                        <h4>Event Restriction:</h4>
                        <div class="btn-group gap-2" role="group">
                            <input type="radio" class="btn-check" name="restriction" id="restriction1"
                                autocomplete="off" value="public" @if ((!empty($event) && !$event->is_private) || old('restriction') == 'public') checked @endif>
                            <label class="btn btn-outline-primary" for="restriction1">Public</label>

                            <input type="radio" class="btn-check" name="restriction" id="restriction2"
                                autocomplete="off" value="private" @if ((!empty($event) && $event->is_private) || old('restriction') != 'public' || empty($event)) checked @endif>
                            <label class="btn btn-outline-primary" for="restriction2">Private</label>
                        </div>
                    </div>

                    <div class="">
                        <fieldset id="optionsSet" class="d-none">
                            @foreach ($tags as $tag)
                                <input id="t{{ $tag->id }}" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    @if (!empty($event) && $event->tags->contains($tag)) checked @endif>
                            @endforeach
                        </fieldset>

                        <div class="col-lg-6 col-12">
                            <h4>Tags:</h4>
                            <div id="tagsDiv" class="w-100 d-flex justify-content-start flex-wrap">
                                <span id="tagEx" class="tag m-1 removable d-none" title="Click to remove"
                                    onclick="removeTag(this);"> </span>
                                @if (!empty($event))
                                    @foreach ($event->tags as $tag)
                                        <span class="tag m-1 removable" title="Click to remove" onclick="removeTag(this);">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <!-- Add tags -->
                            </label>
                            <input type="search" list="tagOptions" autocomplete="off" id="selec"
                                placeholder="Search tag...">
                            <datalist id="tagOptions">
                                @foreach ($tags as $tag)
                                    <option id="{{ $tag->name }}" data-id="t{{ $tag->id }}"
                                        value="{{ $tag->name }}">
                                    </option>
                                @endforeach
                            </datalist>
                            <button type="button" class="btn btn-custom" onclick="addTag('selec', 'tagsDiv');">Add</button>
                            <label>
                                <!-- Add tags -->
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-custom"> @if ($event ?? '') Edit @else Create @endif </button>
        </div>
        <div id="map-wrapper" class="col-6 position-fixed" style="right: 0">
            <div id="map" class="w-100">

            </div>

            <script>
                 let navbar = document.getElementById("navbar");
                document.getElementById("map").style.height = window.innerHeight - navbar.offsetHeight + "px";
                @if ($event->location ?? '')
                    let eventCoords = [{{ $event->location->lat }}, {{ $event->location->long }}];
                    giveBlack();
                @else
                    let eventCoords = [51.505, -0.09];
                @endif
                let map = L.map('map').setView(eventCoords, 17);
                L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'pk.eyJ1IjoiYnJ1bm9nb21lczMwIiwiYSI6ImNreWxnbzltMzAwYTgydnBhaW81OGhha24ifQ.X-WsoAxJ_WcIlFoQpR4rFA'
                }).addTo(map);
                @if ($event->location ?? '')
                    let mapMarker = L.marker(eventCoords).addTo(map);
                @else
                    let mapMarker = null;
                @endif

                map.on('click', async function(ev) {
                    clickMap(ev);
                });
            </script>
        </div>

        <form>
        @endsection
