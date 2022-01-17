@foreach ($polls as $poll)
    @include('partials.events.poll', compact('poll', 'can_vote'))
@endforeach
