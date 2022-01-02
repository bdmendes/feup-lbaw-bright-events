@extends('layouts.app')

@section('title', 'home')

@section('content')

    <form action="{{ empty($event) ? route('createEvent') : route('editEvent', ['id' => $event->id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @if (!empty($event))
            <input type="hidden" name="id" id="id" value="{{ $event->id }}" />
            hellllo
        @endif
        <div class="d-flex align-items-lg-center flex-column p-1 pb-3" style="background-color: #91A0AD !important;">
            <div class="p-1 w-100">
                <h1>Event creation</h1>
            </div>

            <!--
                                    <div class="p-3 w-100">
                                            is_private[required], date[required], event_state[required], cover_image_id, location_id
                                    </div>
                                    -->
            <!-- Event title -->
            <div class="p-3 w-100 content-float">
                <div class="col-lg-6 col-12 mb-2">
                    <label class="w-100"> Event title:</label>
                    <input id="title" name="title" placeholder="Insert event title" @if ($event ?? '') value="{{ $event->title ?: '' }}" @endif
                        onchange="removeErrors('title');" class=" @if ($errors->has('title')) errorBorder @endif" />
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
                    <input type="date" name="date" id="date" onchange="removeErrors('date')" @if ($event ?? '') value="{{ $event->date->format('Y-m-d') }}" @endif
                        class=" @if ($errors->has('date')) errorBorder @endif" />

                    @if ($errors->has('date'))
                        <span id="dateError" class="error">
                            {{ $errors->first('date') }}
                        </span>
                    @endif
                </div>
                <!-- Is private -->
                <div class="col-lg-6 col-sm-12 col-12 mb-2">
                    <label class="p-2 w-100"> Event restriction </label>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="restriction" id="restriction1" autocomplete="off"
                            value="public" checked>
                        <label class="btn btn-outline-primary" for="restriction1">Public</label>

                        <input type="radio" class="btn-check" name="restriction" id="restriction2" autocomplete="off"
                            value="private">
                        <label class="btn btn-outline-primary" for="restriction2">Private</label>
                    </div>
                </div>
            </div>



            <!-- Tags -->
            <div class="p-3 w-100 content-float">
                <div class="col-lg-6 col-sm-12 col-12 mb-2 ">
                    <label class="p-2 w-100"> Tags </label>
                    <div id="tagsDiv" class="w-100 d-flex justify-content-start flex-wrap">
                        <span class="tag m-1 removable hidden" title="Click to remove" onclick="removeTag(this);"> </span>
                        @if ($event ?? ('' ?? ''))
                            @foreach ($event->tags as $tag)
                                <input type="hidden" name="tags[]" value="{{ $tag->id }}"
                                    id="tag{{ $tag->id }}" />

                                <span class="tag m-1 removable" title="Click to remove" onclick="removeTag(this);"
                                    value="{{ $tag->id }}">
                                    {{ $tag->name }}
                                </span>

                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12 col-12">
                    <label class="p-2 w-100"> Add tags </label>
                    <input list="tagOptions" id="tag" placeholder="Search tag...">
                    <datalist id="tagOptions">
                        @foreach ($tags as $tag)
                            <option data-value="{{ $tag->id }}" value="{{ $tag->name }}"> </option>
                        @endforeach
                    </datalist>
                    <button type="button" onclick="addItem('tagsDiv', 'tag', 'tags'); clearValue('tag');"
                        class="btn btn-primary"> Add </button>
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

            <button type="submit" class="btn btn-primary"> @if ($event ?? '') Edit @else Create @endif </button>

        </div>
        <form>
        @endsection
