@if ($event->tags ?? '')
    @foreach ($event->tags as $tag)
        <span class="tag"> {{ $tag->name }}</span>
    @endforeach
@else
    <span>No tags</span>
@endif
