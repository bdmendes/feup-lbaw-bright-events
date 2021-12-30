<ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#personal-info" type="button" role="tab" aria-controls="home" aria-selected="true">Personal Info</button>
    </li>
    <li class="nav-item" role="presentation">
        @if (Auth::check() && Auth::user()->id == $user->id)
            <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="profile" aria-selected="false">My Events</button>
        @else
            <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="profile" aria-selected="false">Organized Events</button>
        @endif
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="attendances-tab" data-bs-toggle="tab" data-bs-target="#attendances" type="button" role="tab" aria-controls="contact" aria-selected="false">Attendances</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="personal-info" role="tabpanel" aria-labelledby="home-tab">
        <div class="w-100 p-4">
            Info
        </div>
    </div>
    <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="contact-tab">
        <div class="w-100 p-4">
            @foreach ($user->events as $event)
            <a href="{{ route('event', ['id' => $event->id])}}" class="text-decoration-none">
                <div class="card bg-light text-dark mt-2">
                    @if (!is_null($event->cover_image_id))
                        <img src="{{$event->cover_image_id}}" alt="Event image">
                    @endif
                    <h3 class="card-title">{{$event->title}}</h3>
                    <p class="text-grey">{{date('j F, Y', strtotime($event->date))}}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="tab-pane fade" id="attendances" role="tabpanel" aria-labelledby="contact-tab">
        <div class="w-100 p-4">
            @foreach ($attended_events as $event)
            <a href="{{ route('event', ['id' => $event->id])}}" class="text-decoration-none">
                <div class="card bg-light text-dark mt-2">
                    @if (!is_null($event->cover_image_id))
                        <img src="{{$event->cover_image_id}}" alt="Event image">
                    @endif
                    <h3 class="card-title">{{$event->title}}</h3>
                    <p class="text-grey">{{date('j F, Y', strtotime($event->date))}}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
  </div>

  <style>
      .nav-item .active {
          border-color: blue !important;
          color: white !important;
          background-color: transparent !important;
          border-top: 0 !important;
          border-left: 0 !important;
          border-right: 0 !important;
          border-top-color: transparent !important;
          border-left-color: transparent !important;
          border-right-color: transparent !important;
      }

      .nav-link:hover {
          border-top-color: transparent !important;
          border-left-color: transparent !important;
          border-right-color: transparent !important;
      }
  </style>

  @yield('tabview')
