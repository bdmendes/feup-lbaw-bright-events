<ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#personal-info" type="button" role="tab" aria-controls="home" aria-selected="true">Personal Info</button>
    </li>
    <li class="nav-item" role="presentation">
        @if (Auth::check() && Auth::user()->id == $user->id)
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="profile" aria-selected="false">My Events</button>
        @else
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab" aria-controls="profile" aria-selected="false">Organized Events</button>
        @endif
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#attendances" type="button" role="tab" aria-controls="contact" aria-selected="false">Attendances</button>
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
            Events
        </div>
    </div>
    <div class="tab-pane fade" id="attendances" role="tabpanel" aria-labelledby="contact-tab">
        <div class="w-100 p-4">
            Attendances
        </div>
    </div>
  </div>

  @yield('tabview')
