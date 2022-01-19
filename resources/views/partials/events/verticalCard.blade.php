<div class="text-dark card mb-3">
    <div class="col gap-0 w-100">
        <a href="{{ route('event', ['id' => $event->id]) }}" class="col" style="max-width: 250px;">
            <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="img-fluid rounded-start"
                alt="Event cover image" style="height: 400px; width: 100%; object-fit: cover;">
        </a>
        <div class="col-12">
            <div class="card-body d-flex justify-content-between align-items-center w-100">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    @include('partials.users.smallCard', ['user' => $event->organizer])
                    @include("partials.events.tags", ['event' => $event])
                </div>
                <a class="text-dark" href="{{ route('event', ['id' => $event->id]) }}" style="text-decoration: none;">
                    <h3 class="card-title text-end">{{ Str::words($event->title, 15) }}</h3>
                    <h4 class="card-text text-end">{{ date('d/m/Y', strtotime($event->date)) }}
                        @if (!empty($event->location))
                            @ {{ $event->location->name }},
                            {{ $event->location->city }},
                            {{ $event->location->country }}
                        @endif
                    </h4>
                </a>
            </div>
        </div>
    </div>
</div>
