<div class="w-100">
    @if ($event->image ?? ('' && $event->image->path ?? ''))
        <img src="/{{ $event->image->path }}" class="eventBackground mx-auto" />
    @else
        <div class="eventBackground mx-auto bg-dark" style="height: 300px"> </div>
    @endif
</div>
<div class="p-1  w-100">
    <div class="p-3  w-100">
        <h1>{{ $event->title }}</h1>
    </div>

    <div class="p-3  w-100">
        <label>Date: </label>
        {{ $event->date->format('d/m/Y H:i') }}
    </div>
    <div class="p-3  w-100">
        <label>Location: </label>
        @if ($event->location ?? '')
            {{ $event->location->pretty_print() }}
        @else
            Not defined
        @endif

    </div>
    <div class="p-3  w-100">
        <label> Organizer: </label>
        {{ $event->organizer->name }}
    </div>
    <div class="p-3 w-100">
        <label> Tags: </label>
        @include("partials.events.tags", ['event' => $event])
    </div>
</div>


@include('partials.events.tabview', ['event' => $event])

<div class="p-1 w-100 d-flex justify-content-end">
    @if (Auth::check())
        @if (Auth::user()->id !== $event->organizer->id)
            <form>
                <button>Attend event</button>
            </form>
        @else

            <button>Delete event</button>
            <form action="{{ route('editEvent', ['id' => $event->id]) }}">
                <button type="submit">Edit event</button>
            </form>
        @endif

    @else
        <button>Need to be logged in to attend</button>
    @endif
</div>
(Buttons not working)
