@if ($comments->count() == 0)
    No replies around here. Be the first to comment!
@else
    @foreach ($comments as $comment)
        @include('partials.events.comment', compact('comment'))
    @endforeach
@endif
