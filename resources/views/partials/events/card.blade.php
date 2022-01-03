<a style="text-decoration: none;" class="text-dark card mb-3" href="{{ route('event', ['id' => $event->id]) }}">
    <div class="row gap-0">
        <div class="col" style="max-width: 250px;">
            <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="img-fluid rounded-start"
                alt="Event cover image" style="height: 150px; width: 100%; object-fit: cover;">
        </div>
        <div class="col-8">
            <div class="card-body">
                <h3 class="card-title">{{ Str::words($event->title, 15) }}</h3>
                <h4 class="card-text">{{ date('d/m/Y', strtotime($event->date)) }}
                    @if (!empty($event->location))
                        @ {{ $event->location->name }},
                        {{ $event->location->city }},
                        {{ $event->location->country }}
                    @endif
                </h4>
                <div class="d-flex flex-wrap pt-4 gap-2 align-items-center">
                    @include('partials.users.smallCard', ['user' => $event->organizer])
                    @include("partials.events.tags", ['event' => $event])
                </div>
            </div>
        </div>
    </div>
</a>
