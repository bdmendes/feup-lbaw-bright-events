@foreach ($attendances as $attendance)
    <div id="{{ $attendance->attendee->username . '-entry' }}" class="event_attendant border rounded d-flex p-3" style="width: 250px;">
        @if (Auth::check() && Auth::user()->id == $event->organizer_id)
            @include('partials.users.smallCard', ['user' => $attendance->attendee, 'event' =>
            $event])
            <div class="align-self-center" style="margin-left:auto;">
                <button id="{{ $attendance->attendee->username . '-btn' }}" class="btn btn-light"
                    onclick="removeAttendee({{ $event->id }}, {{ $attendance->attendee->id }}, '{{ $attendance->attendee->username }}', false)">
                    <i class="bi bi-x-circle"></i>
                </button>
            </div>
        @else
            @include ('partials.users.smallCard', ['user' => $attendance->attendee])
        @endif
    </div>
@endforeach
