<div class="text-dark card mb-3 event-card">
    <div class="row gap-0 w-100">
        <a href="{{ route('event', ['id' => $event->id]) }}" class="col" style="max-width: 250px;">
            <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="img-fluid rounded-start"
                alt="Event cover image" style="height: 150px; width: 100%; object-fit: cover;">
        </a>
        <div class="col-10">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between gap-4">
                    <a class="text-dark" href="{{ route('event', ['id' => $event->id]) }}" style="text-decoration: none;">
                        <h3 class="card-title">{{ Str::words($event->title, 15) }}</h3>
                        <h4 class="card-text">{{ date('d/m/Y', strtotime($event->date)) }}
                            @if (!empty($event->location))
                                @ {{ $event->location->name }},
                                {{ $event->location->city }},
                                {{ $event->location->country }}
                            @endif
                        </h4>
                    </a>
                    <div class="small-card-wrapper d-flex flex-column">
                        @include('partials.users.smallCard', ['user' => $event->organizer])
                    </div>
                </div>
                <div class="d-flex flex-wrap pt-4 gap-2 align-items-center">
                    @include("partials.events.tags", ['event' => $event])
                </div>
            </div>
        </div>
    </div>
</div>
