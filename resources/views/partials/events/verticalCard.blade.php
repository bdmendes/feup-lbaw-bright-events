<div class="text-dark card mb-3 h-100">
    <div class="col d-flex flex-column">
        <a href="{{ route('event', ['id' => $event->id]) }}" class="col w-100" style="">
            <img src="/{{ $event->image->path ?? 'images/group.jpg' }}" class="img-fluid rounded-start"
                alt="Event cover image" style="height: 400px; width: 100%; object-fit: cover;">
        </a>
        <div class="col-12 flex-grow-1">
            <div class="card-body d-flex flex-column justify-content-between h-100">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        @include('partials.users.smallCard', ['user' => $event->organizer])
                        
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
                @if ($display_tags)
                <div class="d-block mt-2 p-2">
                    @if ($event->tags ?? '')
                        @foreach ($event->tags as $tag)
                            <span class="tag"> {{ $tag->name }}</span>
                        @endforeach
                    @else
                        <span>No tags</span>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
