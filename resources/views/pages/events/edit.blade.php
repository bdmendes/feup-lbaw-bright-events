@extends('layouts.app')

@section('title', 'home')

@section('content')
    @if (empty($event))
        <h2>Event creation</h2>
    @else
        <h2>Edit event</h2>
    @endif

    <form id="eventCE" action="{{ empty($event) ? route('createEvent') : route('editEvent', ['id' => $event->id]) }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @if (!empty($event))
            <input type="hidden" name="id" id="id" value="{{ $event->id }}" />
        @endif
        <div class="d-flex align-items-lg-center flex-column p-1 pb-3">
            <!-- Event title -->
            <div class="p-3 w-100 content-float">
                <div class="col-lg-6 col-12 mb-2">
                    <label class="w-100"> Event title:</label>
                    <input id="title" name="title" placeholder="Insert event title" @if (!empty($event)) value="{{ $event->title }}" @endif />
                </div>
                <div class="col-lg-6 col-12 mb-2">
                    <label class="w-100">Background image:</label>
                    <input id="cover_image" name="cover_image" type="file" />
                </div>

            </div>

            <div class="p-3 w-100 content-float">
                <!-- Event date -->
                <div class="col-lg-6 col-sm-12 col-12 mb-2">
                    <label class="w-100"> Event date: </label>
                    <input type="date" name="date" id="date" @if (!empty($event)) value="{{ $event->date->format('Y-m-d') }}" @endif />
                </div>

                <!-- Visibility -->
                <div class="col-lg-6 col-sm-12 col-12 mb-2">
                    <label class="p-2 w-100"> Event restriction </label>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="restriction" id="restriction1" autocomplete="off"
                            value="public" @if (!empty($event) && !$event->is_private) checked @endif>
                        <label class="btn btn-outline-primary" for="restriction1">Public</label>

                        <input type="radio" class="btn-check" name="restriction" id="restriction2" autocomplete="off"
                            value="private" @if (empty($event) || $event->is_private) checked @endif>
                        <label class="btn btn-outline-primary" for="restriction2">Private</label>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="p-3 w-100 content-float">
                <fieldset id="optionsSet" class="d-none">
                    @foreach ($tags as $tag)
                        <input id="t{{ $tag->id }}" type="checkbox" name="tags[]" value="{{ $tag->name }}"
                            @if (!empty($event) && $event->tags->contains($tag)) checked @endif>
                    @endforeach
                </fieldset>

                <div class="col-lg-6 col-sm-12 col-12 mb-2 ">
                    <label class="p-2 w-100"> Tags </label>
                    <div id="tagsDiv" class="w-100 d-flex justify-content-start flex-wrap">
                        @if (!empty($event))
                            @foreach ($event->tags as $tag)
                                <span class="tag m-1 removable" title="Click to remove" onclick="removeTag(this);">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-12">
                    <label class="p-2 w-100"> Add tags </label>
                    <input list="tagOptions" id="selec" placeholder="Search tag...">
                    <datalist id="tagOptions">
                        @foreach ($tags as $tag)
                            <option id="{{ $tag->name }}" data-id="t{{ $tag->id }}" value="{{ $tag->name }}">
                            </option>
                        @endforeach
                    </datalist>
                    <button type="button" onclick="addTag('selec', 'tagsDiv');">
                        Add
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div class="p-3 w-100">
                <label class="p-2 w-100"> Description </label>
                <textarea id="description" name="description"
                    placeholder="Insert description">@if (!empty($event)){{ $event->description }}@endif</textarea>
            </div>

            <button type="submit" form="eventCE"> @if (empty($event)) Create @else Edit @endif </button>

        </div>
        <form>
        @endsection
