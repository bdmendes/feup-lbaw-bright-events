@if ($comments->count() != 0)
    @foreach ($comments as $comment)
        @include('partials.events.comment', compact('comment'))
    @endforeach
@endif
