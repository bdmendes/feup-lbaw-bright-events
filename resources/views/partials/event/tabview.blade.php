<ul class="nav nav-tabs w-100 nav-fill" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="home" aria-selected="true">Description</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button" role="tab" aria-controls="profile" aria-selected="false">Forum</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#polls" type="button" role="tab" aria-controls="contact" aria-selected="false">Polls</button>
    </li>
    <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#attendees" type="button" role="tab" aria-controls="contact" aria-selected="false">Attendees</button>
    </li>
    <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#statistics" type="button" role="tab" aria-controls="contact" aria-selected="false">Statistics</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="home-tab">
        <div class="w-100 p-4">
            {{$event->description}}
        </div>
    </div>
    <div class="tab-pane fade" id="forum" role="tabpanel" aria-labelledby="contact-tab">
        Forum
    </div>
    <div class="tab-pane fade" id="polls" role="tabpanel" aria-labelledby="contact-tab">
        polls
    </div>
    <div class="tab-pane fade" id="attendees" role="tabpanel" aria-labelledby="contact-tab">
        attendees
    </div>
    <div class="tab-pane fade" id="statistics" role="tabpanel" aria-labelledby="contact-tab">
        statistics for nerds
    </div>

  </div>
