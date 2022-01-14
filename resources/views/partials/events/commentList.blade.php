@foreach ($comments as $comment)
    @include('partials.events.comment', compact('comment'))
@endforeach
