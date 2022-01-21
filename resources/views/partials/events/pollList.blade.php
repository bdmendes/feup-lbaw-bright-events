@forelse ($polls as $poll)
    @include('partials.events.poll', compact('poll', 'can_vote'))
@empty
    @if (!Auth::check() || Auth::id() != $event->organizer_id)
        <h4 class="m-4">No polls around here</h4>
    @endif
@endforelse
