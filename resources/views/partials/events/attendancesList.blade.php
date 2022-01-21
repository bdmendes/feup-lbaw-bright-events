@foreach ($attendances as $attendance)
    <div id="{{ $attendance->attendee->username . '-entry' }}" class="border rounded d-flex p-1" style="width: 250px;">
        @if (Auth::check() && Auth::user()->id == $event->organizer_id)
            <div class="event_attendant">
                @include('partials.users.smallCard', ['user' => $attendance->attendee, 'event' =>
                $event])
                <div class="align-self-center" style="margin-left:auto;">
                    <button id="{{ $attendance->attendee->username . '-btn' }}" class="btn btn-light"
                        onclick="removeAttendee({{ $event->id }}, {{ $attendance->attendee->id }}, '{{ $attendance->attendee->username }}', false)">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        @else
            <div class="event_attendant">
                @include ('partials.users.smallCard', ['user' => $attendance->attendee])
            </div>
        @endif
    </div>
@endforeach
