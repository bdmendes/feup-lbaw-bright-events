<ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        @if (Auth::check() && Auth::user()->id == $user->id)
            <button class="nav-link active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button"
                role="tab" aria-controls="profile" aria-selected="false">My Events</button>
        @else
            <button class="nav-link active" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button"
                role="tab" aria-controls="profile" aria-selected="false">Organized Events</button>
        @endif
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="attendances-tab" data-bs-toggle="tab" data-bs-target="#attendances"
            type="button" role="tab" aria-controls="contact" aria-selected="false">Attendances</button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="events" role="tabpanel" aria-labelledby="contact-tab">
        <div class="w-100 p-4">
            @forelse ($user->events as $event)
                @include('partials.events.card', compact('event'))
            @empty
                <p class="text-grey disabled">Nothing to see here</p>
            @endforelse
        </div>
    </div>
    <div class="tab-pane fade" id="attendances" role="tabpanel" aria-labelledby="contact-tab">
        <div class="w-100 p-4">
            @forelse ($attended_events as $event)
                @include('partials.events.card', compact('event'))
            @empty
                <p class="text-grey disabled">Nothing to see here</p>
            @endforelse
        </div>
    </div>
</div>

<style>
    .nav-item .active {
        border-color: blue !important;
        color: white !important;
        background-color: transparent !important;
        border-top: 0 !important;
        border-left: 0 !important;
        border-right: 0 !important;
        border-top-color: transparent !important;
        border-left-color: transparent !important;
        border-right-color: transparent !important;
    }

    .nav-link:hover {
        border-top-color: transparent !important;
        border-left-color: transparent !important;
        border-right-color: transparent !important;
    }

</style>

@yield('tabView')
