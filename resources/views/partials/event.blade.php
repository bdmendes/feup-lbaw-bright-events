<div class="w-100">
    <img src="https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F203018239%2F227342121523%2F1%2Foriginal.20211220-101832?w=800&auto=format%2Ccompress&q=75&sharp=10&rect=0%2C24%2C1002%2C501&s=ac1247a6305dd65956da5d4e85685c75" class="eventBackground mx-auto"/>
</div>
<div class="p-1  w-100">
    <div class="p-3  w-100">
        <h1>{{$event->title}}</h1>
    </div>

    <div class="p-3  w-100">
        <label>Date: </label>
        {{$event->date->format('d/m/Y H:i')}}
    </div>
    <div class="p-3  w-100">
        <label>Location: </label>
        @if($event->location ?? '')
            {{$event->location->pretty_print()}}
        @else
            Not defined
        @endif

    </div>
    <div class="p-3  w-100">
        <label> Organizer: </label>
        {{$event->organizer->name}}
    </div>
    <div class="p-3 w-100">
        <label> Tags: </label>
        @include("partials.event.tags", ['event' => $event])
    </div>
</div>


@include('partials.event.tabview', ['event' => $event])

<div class="p-1 w-100 d-flex justify-content-end">
    @if (Auth::check())
        @if(Auth::user()->id !== $event->organizer->id)
        <form>
            <button>Attend event</button>
        </form>
        @else
        <form>
            <button>Delete event</button>
            <button>Edit event</button>
        </form>
        @endif

    @else
    <button>Need to be logged in to attend</button>
    @endif
</div>
(Buttons not working)
