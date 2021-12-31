

@if($event->tags ?? '' )
    @foreach ($event->tags as $tag)
        <span class="tag m-1"> {{$tag->name}}</span>
    @endforeach
@else
    Event doesn't have tags
@endif
