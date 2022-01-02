<a style="text-decoration: none;" class="text-dark card mb-3" href="{{ route('event', ['id' => $event->id]) }}">
    <div class="row gap-0">
        <div class="col" style="max-width: 250px;">
            <img src="{{ !empty($event->image) ? '/' . $event->image->path : 'https://img.evbuc.com/https%3A%2F%2Fcdn.evbuc.com%2Fimages%2F203018239%2F227342121523%2F1%2Foriginal.20211220-101832?w=800&auto=format%2Ccompress&q=75&sharp=10&rect=0%2C24%2C1002%2C501&s=ac1247a6305dd65956da5d4e85685c75' }}"
                class="img-fluid rounded-start" alt="Event cover image" style="height: 100%; object-fit: cover;">
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
