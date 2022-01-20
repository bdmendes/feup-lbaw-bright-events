@extends('layouts.app')

@section('title', 'home')

@section('content')


    <form id="eventCE"
     action="{{ empty($event) ? route('createEvent') : route('editEvent', [$event->id]) }}"
     enctype="multipart/form-data"
     method="post">
        @csrf
        @if (!empty($event))
            <input type="hidden" name="id" id="id" value="{{ $event->id }}" />
        @endif
        <div class="d-flex align-items-lg-center flex-column border rounded p-1 pb-3">
            <div class="w-100 p-1">
                @if (empty($event))
                    <h2>Event creation</h2>
                @else
                    <h2>Edit event</h2>
                @endif
            </div>
            <!-- Event title -->
            <div class="p-3 w-100 content-float">
                <div class="col-lg-6 col-12 mb-2 pe-5">
                    <label class="w-100"> Event title:</label>
                    <input id="title"
                         type="text"
                         name="title"
                         class="col-lg-8 col-12
                            @if ($errors->has('title')) errorBorder @endif"
                         onchange="removeErrors('title');"
                         placeholder="Insert event title" @if (!empty($event)) value="{{ $event->title }}" @endif />

                    @if ($errors->has('title'))
                        <span id="titleError" class="error">
                            {{ $errors->first('title') }}
                        </span>
                    @endif
                </div>
                <div class="col-lg-6 col-12 mb-2">
                    <label class="w-100">Background image:</label>
                    <input id="cover_image" name="cover_image" type="file" class="w-100"
                        onchange="remove('cover_imageError');" />
                    @if ($errors->has('cover_image'))
                        <span id="cover_imageError" class="error">
                            {{ $errors->first('cover_image') }}
                        </span>
                    @endif
                </div>

            </div>

            <div class="p-3 w-100 content-float">
                <!-- Event date -->
                <div class="col-lg-6 col-sm-12 col-12 mb-2">
                    <label class="w-100"> Event date: </label>
                    <input type="datetime-local" name="date"
                         id="date"
                         onchange="removeErrors('date');"
                         @if (!empty($event)) value="{{ $event->date->format('Y-m-d\TH:i') }}" @endif
                         class="@if ($errors->has('date')) errorBorder @endif" />

                    @if ($errors->has('date'))
                        <span id="dateError" class="error">
                            {{ $errors->first('date') }}
                        </span>
                    @endif
                </div>

                <!-- Visibility -->
                <div class="col-lg-6 col-sm-12 col-12 mb-2">
                    <label class="p-2 w-100"> Event restriction </label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="restriction" id="restriction1" autocomplete="off"
                            value="public" @if (!empty($event) && !$event->is_private) checked @endif>
                        <label class="btn btn-outline-primary" for="restriction1">Public</label>

                        <input type="radio" class="btn-check" name="restriction" id="restriction2" autocomplete="off"
                            value="private" @if (empty($event) || $event->is_private) checked @endif>
                        <label class="btn btn-outline-primary" for="restriction2">Private</label>
                    </div>
                </div>
            </div>

            <div class="p-3 w-100 content-float">
                <label class="p-2 w-100">Location</label>
                <div class="col-lg-6 col-12 p-3">
                    <label class="p-2 w-100">Search:</label>
                    <input type="text"
                            placeholder="Search map"
                           id="mapGlobalFilter"/>

                    <button onclick="searchMap();" type="button">Search</button>

                    <input type="hidden" id="lat" name="lat" />
                    <input type="hidden" id="long" name="long" />

                    <label class="p-2 w-100">City:</label>
                    <input type="text" class="transparent" id="city" name="city" />

                    <label class="p-2 w-100">Country:</label>
                    <input type="text" class="transparent" id="country" name="country" readonly="readonly"/>

                    <label class="p-2 w-100">Display name:</label>
                    <input type="text" class="transparent" id="display_name" name="display_name"/>

                    <label class="p-2 w-100">Postcode:</label>
                    <input type="text" class="transparent" id="postcode" name="postcode" readonly="readonly"/>


                </div>
                <div class="col-lg-6 col-12">
                    <div id="map"
                        class="w-100"
                        style="height: 400px">

                    </div>

                </div>
                <script>
                    let map = L.map('map').setView([51.505, -0.09], 13);
                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                    maxZoom: 18,
                    id: 'mapbox/streets-v11',
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken: 'pk.eyJ1IjoiYnJ1bm9nb21lczMwIiwiYSI6ImNreWxnbzltMzAwYTgydnBhaW81OGhha24ifQ.X-WsoAxJ_WcIlFoQpR4rFA'
                }).addTo(map);

                    let mapMarker = null;

                    map.on('click',async function(ev)  {
                        let cityHtml = document.getElementById("city");
                        let postcodeHtml = document.getElementById("postcode");
                        let countryHtml = document.getElementById("country");
                        let displayNameHtml = document.getElementById("display_name");
                        let latHtml = document.getElementById("lat");
                        let longHtml = document.getElementById("long");
                        cityHtml.classList.remove("black");
                        postcodeHtml.classList.remove("black");
                        countryHtml.classList.remove("black");
                        displayNameHtml.classList.remove("black");
                        if(mapMarker != null){
                            map.removeLayer(mapMarker);
                        }
                        mapMarker = L.marker(ev.latlng).addTo(map);
                        let data = await getAddress(ev.latlng.lat, ev.latlng.lng);
                        let display_name = data['display_name'];
                        let address = data["address"];
                        let postcode = address["postcode"];
                        let city = address["city"];
                        let country = address["country"];

                        console.log("Address = " + JSON.stringify(address));


                        cityHtml.value = city;
                        cityHtml.classList.add("black");

                        postcodeHtml.value = postcode;
                        postcodeHtml.classList.add("black");

                        countryHtml.value = country;
                        countryHtml.classList.add("black");

                        displayNameHtml.value = display_name;
                        displayNameHtml.classList.add("black");

                        latHtml.value = ev.latlng.lat;
                        longHtml.value = ev.latlng.lng;
                    });
                </script>
            </div>

            <!-- Tags -->
            <div class="p-3 w-100 content-float">
                <fieldset id="optionsSet" class="d-none">
                    @foreach ($tags as $tag)
                        <input id="t{{ $tag->id }}" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            @if (!empty($event) && $event->tags->contains($tag)) checked @endif>
                    @endforeach
                </fieldset>

                <div class="col-lg-6 col-12 mb-2 ">
                    <label class="p-2 w-100"> Tags </label>
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
                    <label class="p-2 w-100"> <!-- Add tags --> </label>
                    <input list="tagOptions" id="selec" placeholder="Search tag...">
                    <datalist id="tagOptions">
                        @foreach ($tags as $tag)
                            <option id="{{ $tag->name }}" data-id="t{{ $tag->id }}" value="{{ $tag->name }}">
                            </option>
                        @endforeach
                    </datalist>
                    <button type="button"
                            class="btn-primary"
                            onclick="addTag('selec', 'tagsDiv');">
                        Add
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div class="p-3 w-100">
                <label class="p-2 w-100"> Description </label>
                <textarea id="description" name="description" placeholder="Insert description"
                    class=" @if ($errors->has('description')) errorBorder @endif"
                    onchange="removeErrors('description');">@if ($event ?? ''){{ $event->description ?: '' }}@endif</textarea>
                @if ($errors->has('description'))
                    <span id="descriptionError" class="error">
                        {{ $errors->first('description') }}
                    </span>
                @endif
            </div>

            <button type="submit"
                    class="btn-primary "> @if ($event ?? '') Edit @else Create @endif </button>

        </div>
        <form>
        @endsection
