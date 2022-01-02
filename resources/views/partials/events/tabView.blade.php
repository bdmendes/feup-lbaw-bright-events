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
                            onclick="removeAttendee({{ $event->id }}, {{ Auth::user()->id }}, '{{ Auth::user()->username}}', '{{ !empty(Auth::user()->profile_picture) ? '/' . Auth::user()->profile_picture->path : 'https://marriedbiography.com/wp-content/uploads/2021/01/Linus-Torvalds.jpg' }}', '{{Auth::user()->name}}', true)"
                            id="attend_button" type="submit">Leave event</button>
                    @else
                        <button class="btn-light"
                            onclick="addAttendee({{ $event->id }}, {{ Auth::user()->id }}, '{{ Auth::user()->username}}', '{{ !empty(Auth::user()->profile_picture) ? '/' . Auth::user()->profile_picture->path : 'https://marriedbiography.com/wp-content/uploads/2021/01/Linus-Torvalds.jpg' }}', '{{Auth::user()->name}}', true)"
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
        <div class="p-4 d-flex gap-4 flex-wrap justify-content" id="attendees-list">
            @forelse ($event->attendees() as $user)
                <div id="{{ $user->username . '-entry' }}" class="border rounded d-flex p-1" style="width: 250px;">
                    @if (Auth::check() && Auth::user()->id == $event->organizer_id)
                        @include('partials.users.smallCard', compact('user'), compact('event'))
                        <div class="align-self-center" style="margin-left:auto;">
                            <button id="{{ $user->username . '-btn' }}" class="btn btn-light"
                                onclick="removeAttendee({{ $event->id }}, {{ $user->id }}, '{{ $user->username }}', null, null, false)">
                                <i class="bi bi-x-circle"></i>
                            </button>
                        </div>
                    @else
                        @include ('partials.users.smallCard', compact('user'))
                    @endif
                </div>
            @empty
                <p>No attendees around here...</p>
            @endforelse
        </div>
    </div>
    <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="contact-tab">
        <p>Statistics not implemented yet</p>
    </div>
</div>
