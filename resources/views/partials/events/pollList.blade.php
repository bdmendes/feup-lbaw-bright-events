@forelse ($polls as $poll)
    @include('partials.events.poll', compact('poll'))
@empty
    <p class="mx-2">No polls around here</p>
@endforelse
