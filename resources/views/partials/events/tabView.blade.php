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
            {{ $event->description ?? 'Event has no description' }}
        </div>
        <div class="d-flex justify-content-end">
            @if ($event->organizer !== null)
                @if (Auth::check())
                    @if (Auth::user()->id !== $event->organizer->id)
                        @if (Auth::user()->attends($event->id))
                            <button class="btn-light"
                                onclick="removeAttendee({{ $event->id }}, {{ Auth::user()->id }}, '{{ Auth::user()->username }}', true)"
                                id="attend_button" type="submit">Leave event</button>
                        @else
                            <button class="btn-light"
                                onclick="addAttendee({{ $event->id }}, {{ Auth::user()->id }}, '{{ Auth::user()->username }}', true)"
                                id="attend_button">Attend
                                event</button>
                        @endif
                    @else
                        <form action="{{ route('event', ['id' => $event->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="id" id="id" value="{{ $event->id }}" />
                            <button class="btn btn-primary mx-2" type="submit">Delete event</button>
                        </form>
                        <form action="{{ route('editEvent', ['id' => $event->id]) }}">
                            <button class="btn btn-primary " type="submit">Edit event</button>
                        </form>
                    @endif

                @else
                    <button disabled>Login to attend event</button>
                @endif
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

        @if (Auth::check() && Auth::user()->id == $event->organizer_id)
            <!-- Invite user -->
            <div class="col-lg-6 col-sm-12 col-12">
                <h3>Invite user</h3>
                <input list="userOptions" id="selectUser" placeholder="Search user...">
                <datalist id="userOptions">
                    @foreach ($users as $user)
                        <option id="{{ $user->name }}-option" value="{{ $user->username }}">
                        </option>
                    @endforeach
                </datalist>
                <button type="button" onclick="inviteUser({{ $event->id }});">
                    Invite
                </button>
            </div>
            <br>

            <h3>Currently invited users</h3>

            <!-- Current invites -->
            <div id="invitees">
                @foreach ($invites as $invite)
                    <div class="border rounded d-flex p-1" style="width: 250px;">
                        @include('partials.users.smallCard', ['user' => $users->find($invite->attendee_id)])
                    </div>
                @endforeach
            </div>

            <br>
            <h3>Attendees</h3>
        @endif

        <div class="p-4 d-flex gap-4 flex-wrap justify-content" id="attendees-list">
            @forelse ($event->attendees() as $user)
                <div id="{{ $user->username . '-entry' }}" class="border rounded d-flex p-1" style="width: 250px;">
                    @if (Auth::check() && Auth::user()->id == $event->organizer_id)
                        @include('partials.users.smallCard', compact('user'), compact('event'))
                        <div class="align-self-center" style="margin-left:auto;">
                            <button id="{{ $user->username . '-btn' }}" class="btn btn-light"
                                onclick="removeAttendee({{ $event->id }}, {{ $user->id }}, '{{ $user->username }}', false)">
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

    <script>
        function inviteUser(eventId) {
            const username = document.getElementById("selectUser").value;

            let xmlHTTP = new XMLHttpRequest();
            xmlHTTP.open("POST", "/api/events/" + eventId + "/invites", false);
            xmlHTTP.setRequestHeader(
                "Content-type",
                "application/x-www-form-urlencoded"
            );

            xmlHTTP.onreadystatechange = function() {
                if (xmlHTTP.readyState == 4) {
                    if (xmlHTTP.status == 200) {
                        let html = JSON.parse(xmlHTTP.response).html;
                        let invitees = document.getElementById('invitees');
                        let div = document.createElement('id');
                        div.classList.add("border", "rounded", "d-flex", "p-1");
                        div.style.width = "250px";
                        div.innerHTML += html;

                        invitees.appendChild(div);
                    } else {
                        alert(xmlHTTP.status + ': Something went wrong');
                    }
                }
            };

            xmlHTTP.send("username=" + username);
        }
    </script>
</div>
