@extends('layouts.app')

@section('title', 'home')

@section('content')
    <div class="container w-md-75 border rounded p-4">
        <div class="w-100">
            <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="eventBackground mx-auto" />
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
                @include('partials.users.smallCard', ['user' => $event->organizer])
            </div>
            <div class="p-3 w-100">
                <label> Tags: </label>
                @include("partials.events.tags", ['event' => $event])
            </div>
            @if (Auth::check() && Auth::id() != $event->organizer_id)
                <div id="report-container" class="text-end pe-1">
                    <span class="link-primary" style="font-size: 0.9em;" type="button"
                        onclick="getReportModal('event', {{ $event->id }});">Report
                        event</span>
                </div>
            @endif
        </div>

        <ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                    type="button" role="tab" aria-controls="description" aria-selected="true"
                    onclick="appendToUrl('')">Description</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button"
                    role="tab" aria-controls="forum" aria-selected="false"
                    onclick="appendToUrl('#forum'); getComments();">Forum</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="polls-tab" data-bs-toggle="tab" data-bs-target="#polls" type="button"
                    role="tab" aria-controls="polls" aria-selected="false"
                    onclick="appendToUrl('#polls'); getPolls();">Polls</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="attendees-tab" data-bs-toggle="tab" data-bs-target="#attendees"
                    type="button" role="tab" aria-controls="attendees" aria-selected="false"
                    onclick="appendToUrl('#attendees')">Attendees</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics"
                    type="button" role="tab" aria-controls="statistics" aria-selected="false"
                    onclick="appendToUrl('#statistics')">Statistics</button>
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
                            @if (Auth::user()->id !== $event->organizer->id && !Auth::user()->is_admin)
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
                                    <button class="btn btn-primary mx-2" type="submit">
                                        @if ($event->organizer->id === Auth::user()->id)
                                            Delete event
                                        @endif
                                        @if (Auth::user()->is_admin)
                                            Disable event
                                        @endif
                                    </button>
                                </form>
                                @if (Auth::user()->id === $event->organizer->id)
                                    <form action="{{ route('editEvent', ['id' => $event->id]) }}">
                                        <button class="btn btn-primary " type="submit">Edit event</button>
                                    </form>
                                @endif
                            @endif

                        @else
                            <button disabled>Login to attend event</button>
                        @endif
                    @endif
                </div>
            </div>

            <div class="tab-pane fade" id="forum" role="tabpanel" aria-labelledby="contact-tab">
                @if (Auth::check() && !Auth::user()->is_admin)
                    <form class="mt-4">
                        <input type="text" id="new_comment_body" name="body" placeholder="What do you think of this event?">
                        <button id="submit_comment_button" class="mt-2" type="button"
                            onclick="submitComment();">Submit</button>
                    </form>
                @endif
                <script>
                    let eventChannel = pusher.subscribe("event-channel-{{ $event->id }}");

                    eventChannel.bind('event', function(data) {
                        if (data.message === 'comment') {
                            remove('comment_area:refreshIcon');
                            prependComment(data.id);
                        } else if (data.message === 'poll') {
                            updatePoll(data.id);
                        }
                    });
                </script>
                <div id="comment_area">

                </div>
                <button id="view_more_comments" style="display: none;" onclick="viewMoreComments();">View more</button>
            </div>

            <div class="tab-pane fade" id="polls" role="tabpanel" aria-labelledby="contact-tab">
                @if (Auth::check() && Auth::id() == $event->organizer->id)
                    <button id="new_poll_button" class="mt-4 mb-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#new_poll_area" aria-expanded="false" aria-controls="new_poll_area">
                        Create poll
                    </button>
                    <div class="collapse" id="new_poll_area">
                        <div class="card card-body">
                            @include('partials.events.newPoll', compact('event'))
                        </div>
                    </div>
                @endif
                <div class="accordion accordion-flush mt-2" id="poll_area">
                </div>
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
                    @forelse ($event->attendances as $attendance)
                        <div id="{{ $attendance->attendee->username . '-entry' }}" class="border rounded d-flex p-1"
                            style="width: 250px;">
                            @if (Auth::check() && Auth::user()->id == $event->organizer_id)
                                @include('partials.users.smallCard', compact('user'), compact('event'))
                                <div class="align-self-center" style="margin-left:auto;">
                                    <button id="{{ $user->username . '-btn' }}" class="btn btn-light"
                                        onclick="removeAttendee({{ $event->id }}, {{ $attendance->attendee->id }}, '{{ $attendance->attendee->username }}', false)">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </div>
                            @else
                                @include ('partials.users.smallCard', ['user' => $attendance->attendee])
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

    <script>
        function redirectTab() {
            const hash = window.location.hash;
            switch (hash) {
                case "#forum":
                    document.getElementById('forum-tab').click();
                    break;
                case "#polls":
                    document.getElementById('polls-tab').click();
                    break;
                case "#attendees":
                    document.getElementById('attendees-tab').click();
                    break;
                case "#statistics":
                    document.getElementById('statistics-tab').click();
                    break;
                default:
                    break;
            }
        }
        window.addEventListener('load', () => {
            redirectTab();
        });
    </script>

    <script type="text/javascript" src={{ asset('js/report.form.js') }} defer></script>
@endsection
