<ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#description" type="button"
            role="tab" aria-controls="home" aria-selected="true">Description</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button"
            role="tab" aria-controls="profile" aria-selected="false">Forum</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#polls" type="button"
            role="tab" aria-controls="contact" aria-selected="false">Polls</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#attendees" type="button"
            role="tab" aria-controls="contact" aria-selected="false">Attendees</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#statistics" type="button"
            role="tab" aria-controls="contact" aria-selected="false">Statistics</button>
    </li>
</ul>

<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="home-tab">
        <div class="w-100 p-4">
            {{ $event->description }}
        </div>
        <div class="float-right">
            @if (Auth::check())
                @if (Auth::user()->id !== $event->organizer->id)
                    @if (Auth::user()->attends($event->id))
                        <button class="btn-light"
                            onclick="removeAttendee({{ $event->id }}, {{ Auth::user()->id }}, 'attend_button')"
                            id="attend_button" type="submit">Leave event</button>
                    @else
                        <button class="btn-light"
                            onclick="addAttendee({{ $event->id }}, {{ Auth::user()->id }}, 'attend_button')"
                            id="attend_button">Attend
                            event</button>
                    @endif
                @else
                    <button class="btn btn-primary mx-2">Delete event</button>
                    <form action="{{ route('editEvent', ['id' => $event->id]) }}">
                        <button class="btn btn-primary " type="submit">Edit event</button>
                    </form>
                @endif

            @else
                <button disabled>Attend event</button>
                <br>
                <small class="text-muted">Login to attend event</small>
            @endif
        </div>
    </div>
    <div class="tab-pane fade" id="forum" role="tabpanel" aria-labelledby="contact-tab">
        <p>Forum not implemented yet</p>
    </div>
    <div class="tab-pane fade" id="polls" role="tabpanel" aria-labelledby="contact-tab">
        <p>Polls not implemented yet</p>
    </div>
    <div class="tab-pane fade" id="attendees" role="tabpanel" aria-labelledby="contact-tab">
        <div class="gap-4 m-4 d-flex flex-wrap justify-content-center align-items-center">
            @forelse ($event->attendees() as $user)
                @if (Auth::check() && Auth::user()->id == $event->organizer_id)
                    @include('partials.users.removablecard', compact('user'), compact('event'))
                @else
                    @include ('partials.users.card', compact('user'))
                @endif
            @empty
                <p>No attendees around here...</p>
            @endforelse
        </div>
    </div>
    <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="contact-tab">
        <p>Statistics not implemented yet</p>
    </div>
</div>
