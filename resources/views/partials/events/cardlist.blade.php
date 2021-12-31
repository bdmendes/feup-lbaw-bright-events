<div id="events-list">
    @if ($events->isEmpty())
        No events were found
    @else
        @foreach ($events as $event)
            <div class="mt-4">
                @include('partials.events.card', ['event' => $event])
            </div>
        @endforeach
    @endif
</div>
