@extends('layouts.app')

@section('title', 'home')

@section('styles')
    <link href="{{ asset('css/event.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <script type="text/javascript" src={{ asset('js/event.js') }} defer></script>

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
                        remove("joinRequest"+username);
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


@include('layouts.breadcrumbs', ['pages'=>[
['name' => 'Home', 'route'=> route('home')],
['name' => 'Events','route'=>route('browseEvents')],
['name' => $event->title, 'route'=>route('event', ['id' => $event->id])]]])


@section('content')
    <div id="banner" class="w-100 position-fixed">
        <img class="w-100" src="/{{ $event->image->path ?? 'images/group.jpg' }}" alt="First slide">
    </div>

    <div id="event-content" class="container w-75 border rounded p-4 bg-light my-4">
        <div class="event-image col-sm-12 col-md-12 d-flex d-lg-none d-xl-none">
            <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="w-100" />

        </div>
        <div id="event-header" class="row mb-4">
            <div id="event-info" class="d-flex flex-column col-sm-12 col-md-12 col-lg-6 col-xl-6 p-4 pb-0 gap-3 justify-content-between">
                <div>
                    <div class="w-100">
                        <h1 id="event-title">{{ $event->title }}</h1>
                    </div>
    
                    <div class="w-100 event-subtitle">
                        <label>Date: </label>
                        <span>{{ $event->date->format('d/m/Y H:i') }}</span>
                    </div>
    
                    <div class="d-flex event-subtitle">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <label> Organized by:</label>
                            <span class="border p-3 event-organizer">
                                @include('partials.users.smallCard', ['user' => $event->organizer])
                            </span>
                        </div>
                    </div>
                    <div class="d-flex w-100 event-subtitle">
                        <div class="d-flex flex-column gap-3">
                            <label> Tags: </label>
                            <span id="tags" class="d-flex flex-wrap gap-2">
                                @include("partials.events.tags", ['event' => $event])
                            </span>
                        </div>
                    </div>
                </div>
                    
                <div>
                    <div class="d-flex justify-content-start gap-2">
                        @if ($event->organizer !== null)
                            @if (Auth::check())
                                @if (Auth::user()->id !== $event->organizer->id && !Auth::user()->is_admin)
                                    @if (Auth::user()->attends($event->id))
                                        <button class="btn btn-custom"
                                            onclick="removeAttendee({{ $event->id }}, {{ Auth::user()->id }}, '{{ Auth::user()->username }}', true)"
                                            id="attend_button" type="submit">Leave event</button>
                                    @elseif($userInvite)
                                        <form
                                            action="{{ route('answerInvite', ['eventId' => $event->id, 'inviteId' => $userInvite]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="accept" id="accept" value="true" />
                                            <button class="btn btn-custom mx-2" type="submit">Accept invite</button>
                                        </form>

                                        <form
                                            action="{{ route('answerInvite', ['eventId' => $event->id, 'inviteId' => $userInvite]) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="reject" id="reject" value="false" />

                                            <button class="btn btn-custom mx-2" type="submit">Reject invite</button>
                                        </form>
                                    @elseif($event->is_private)

                                            @if($event->attendanceRequests()->getQuery()->where('attendee_id', Auth::id())->where('is_invite', 'false')->exists())
                                            <button class="btn btn-custom mx-2" type="button"
                                                disabled>
                                                @if($event->attendanceRequests()->getQuery()->where('attendee_id', Auth::id())->where('is_invite', 'false')->where('is_handled', 'false')->exists())
                                                Join request pending
                                                @else
                                                    Join request rejected
                                                @endif
                                            </button>
                                            @else
                                                <form action="{{ route('joinRequest', ['eventId' => $event->id]) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" id="id" value="{{ $event->id }}" />
                                                        <button class="btn btn-custom mx-2" type="submit">Request to join</button>
                                                </form>
                                            @endif
                                    @else
                                        <button class="btn btn-custom"
                                            onclick="addAttendee({{ $event->id }}, {{ Auth::user()->id }}, '{{ Auth::user()->username }}', true)"
                                            id="attend_button">Attend
                                            event</button>
                                    @endif
                                @else
                                    <form action="{{ route('event', ['id' => $event->id]) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-custom" type="submit">
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
                                            <button class="btn btn-custom " type="submit">Edit event</button>
                                        </form>
                                    @endif
                                @endif

                            @else
                                <button class="btn btn-custom" disabled>Login to attend event</button>
                            @endif
                        @endif
                        @if (Auth::check() && Auth::id() != $event->organizer_id)
                                <button class="btn btn-custom" style="font-size: 0.9em;" type="button"
                                    onclick="getReportModal('event', {{ $event->id }});">
                                    Report event
                                </button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="event-image d-none d-lg-flex col-lg-6 col-xl-6">
                <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="w-100" />
            </div>
        </div>

        <div id="event-body">
            @if(!$event->is_private || ($event->is_private && $isAttendee) || $event->organizer_id == Auth::id())
            <ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description"
                        type="button" role="tab" aria-controls="description" aria-selected="true"
                        onclick="replaceHash('')">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button"
                        role="tab" aria-controls="forum" aria-selected="false"
                        onclick="replaceHash('#forum'); getComments();">Forum</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="polls-tab" data-bs-toggle="tab" data-bs-target="#polls" type="button"
                        role="tab" aria-controls="polls" aria-selected="false"
                        onclick="replaceHash('#polls'); getPolls();">Polls</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="attendees-tab" data-bs-toggle="tab" data-bs-target="#attendees"
                        type="button" role="tab" aria-controls="attendees" aria-selected="false"
                        onclick="replaceHash('#attendees'); getAttendees();">Attendees</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics"
                        type="button" role="tab" aria-controls="statistics" aria-selected="false"
                        onclick="replaceHash('#statistics')">Statistics</button>
                </li>
            </ul>
            @endif


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="home-tab">

                    <div class="w-100 p-4">
                        {{ $event->description ?? 'Event has no description' }}
                    </div>
                    <div class="w-100 p-4">
                        <label>Location: </label>
                        @if ($event->location ?? '')
                            <span class="w-50">
                                {{ $event->location->pretty_print() }}
                            </span>
                        @else
                            <span>
                                Not defined
                            </span>
                        @endif
                        <div id="map" class="w-100" style="height:300px">
                        </div>
                        <script>
                            let eventCoords = [{{ $event->location->lat }}, {{ $event->location->long }}];
                            let map = L.map('map').setView(eventCoords, 17);
                            L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                                maxZoom: 18,
                                id: 'mapbox/streets-v11',
                                tileSize: 512,
                                zoomOffset: -1,
                                accessToken: 'pk.eyJ1IjoiYnJ1bm9nb21lczMwIiwiYSI6ImNreWxnbzltMzAwYTgydnBhaW81OGhha24ifQ.X-WsoAxJ_WcIlFoQpR4rFA'
                            }).addTo(map);
                            L.marker(eventCoords).addTo(map)
                        </script>

                    </div>

                </div>

                @if (!$event->is_private || ($event->is_private && $isAttendee) || $event->organizer_id == Auth::id())
                    <div class="tab-pane fade" id="forum" role="tabpanel" aria-labelledby="contact-tab">
                        @if (Auth::check() && !Auth::user()->is_admin)
                            <form class="mt-4 mb-4 d-flex gap-4 align-items-center justify-content-center"
                                onsubmit=" event.preventDefault(); submitComment(); return false;">
                                <input class="input" type="text" id="new_comment_body" name="body"
                                    placeholder="What do you think of this event?">
                                <button id="submit_comment_button" class="btn btn-custom" type="button"
                                    onclick="submitComment();">Submit</button>
                            </form>
                        @endif
                        <script>
                            let eventChannel = pusher.subscribe("event-channel-{{ $event->id }}");

                            eventChannel.bind('event', function(data) {
                                if (data.message === 'comment' && !data.child) {
                                    remove('comment_area:refreshIcon');
                                    prependComment(data.id);
                                } else if (data.message === 'poll') {
                                    updatePoll(data.id);
                                }
                            });
                        </script>
                        <div id="comment_area" class="gap-4 d-flex flex-column">

                        </div>
                        <button id="view_more_comments" class="btn btn-custom mt-4" style="display: none;"
                            onclick="viewMoreComments();">
                            View more
                        </button>
                    </div>

                    <div class="tab-pane fade" id="polls" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="accordion accordion-flush mt-4" id="poll_area">
                        </div>
                        @if (Auth::check() && Auth::id() == $event->organizer->id)
                            <div class="my-4">
                                <button class="btn btn-custom" id="new_poll_button" class="mt-4 mb-2" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#new_poll_area" aria-expanded="false"
                                    aria-controls="new_poll_area">
                                    Create poll
                                </button>
                                <div class="collapse mt-4" id="new_poll_area">
                                    <div class="card card-body">
                                        @include('partials.events.newPoll', compact('event'))
                                    </div>
                                </div>
                            </div>
                        @endif
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

                    <div class="tab-pane fade d-flex flex-column p-4 gap-4" id="attendees" role="tabpanel" aria-labelledby="contact-tab">

                        @if (Auth::check() && Auth::user()->id == $event->organizer_id)
                            <!-- Invite user -->
                            <div class="col-lg-6 col-sm-12 col-12 d-flex flex-column flex-wrap">
                                <h3>Invite user</h3>
                                <div class="d-flex flex-wrap gap-2">
                                    <input list="userOptions" id="selectUser" placeholder="Search user...">
                                    <datalist id="userOptions">
                                        @foreach ($users as $user)
                                            <option id="{{ $user->name }}-option" value="{{ $user->username }}">
                                            </option>
                                        @endforeach
                                    </datalist>
                                    <button class="btn btn-custom"type="button" onclick="inviteUser({{ $event->id }});">
                                        Invite
                                    </button>
                                </div>
                            </div>
                            
                            <div class="">
                                <h3>Currently invited users</h3>
                                <div id="invitees" class="d-flex gap-4 flex-wrap justify-content" >
                                    @forelse ($invites as $invite)
                                        <div class="event-invitee border rounded d-flex p-3" style="width: 250px;">
                                            @include('partials.users.smallCard', ['user' => $users->find($invite->attendee_id)])
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                            <div class="">
                                <h3>Pending join requests</h3>
                                <div id="joinRequests" >
                                    @forelse ($event->attendanceRequests()->getQuery()->where('is_invite', 'false')->where('is_handled', 'false')->get() as $request)
                                        <div id="joinRequest{{$request->attendee->username}}" class="border rounded d-flex p-1" style="width: 250px;">
                                            <div class="col-10">
                                                @include('partials.users.smallCard', ['user' => $request->attendee])
                                            </div>
                                            <div class="d-flex align-items-center col-2">
                                                <span class="col-6 bi-check text-success fs-1 clickable"
                                                        title="Accept join request"
                                                        onclick="answerJoinRequest({{$request->event_id}}, {{$request->id}}, true)"> </span>
                                                <span class="col-6 bi-x text-danger fs-1 clickable"
                                                        title="Reject join request"
                                                        onclick="answerJoinRequest({{$request->event_id}}, {{$request->id}}, false)"> </span>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                        @endif

                        <div>
                            <h3>Attendees</h3>
                            <div class="d-flex gap-4 flex-wrap justify-content" id="attendees-list">

                        </div>
                        <button id="view_more_attendees" class="btn btn-custom mt-4" style="display: none;"
                            onclick="viewMoreAttendees();">
                            View more
                        </button>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="contact-tab">
                        <br>
                        <h2 class="m-2">{{ $event->attendees()->count() }} attendees</h2>
                        <div class="row h-100 d-flex align-items-center">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                @include('partials.charts.ageChart', ['age0' => $ages[0], 'age1' => $ages[1], 'age2' =>
                                $ages[2],
                                'age3'
                                =>
                                $ages[3]])
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                @include('partials.charts.genderChart', ['male' => $genders[0], 'female' => $genders[1],
                                'other' =>
                                $genders[2]])
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
