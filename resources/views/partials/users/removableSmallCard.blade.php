@include('partials.users.smallCard', ['user' => $attendance->attendee])
<div class="align-self-center" style="margin-left:auto;">
    <button id="{{ $attendance->attendee->username . '-btn' }}" class="btn btn-light"
        onclick="removeAttendee({{ $attendance->event->id }}, {{ $attendance->attendee->id }}, '{{ $attendance->attendee->username }}', false)">
        <i class="bi bi-x-circle"></i>
    </button>
</div>
