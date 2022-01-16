<span id="notificationCount" class="d-none">{{count($notifications)}}</span>
@forelse ($notifications as $notification)
<div id="notification{{$notification->id}}" class="notification d-flex w-100 p-2" seen="{{$notification->is_seen ?? '0'}}">
    <div class="col-sm-1">
        @switch($notification->notification_type)
            @case('Disabled event')
                <span class="bi bi-calendar-x"> </span>
                @break

            @case('Cancelled event')
                <span class="bi bi-calendar-x"> </span>
                @break

            @case('Join request')
                <span class="bi bi-calendar-plus"> </span>
                @break

            @case('Accepted request')
                <span class="bi bi-calendar-check"> </span>
                @break

            @case('Declined request')
                <span class="bi bi-calendar-x"> </span>
                @break

            @case('Invite')
                <span class="bi bi-envelope-plus"> </span>
                @break

            @case('Accepted invite')
                <span class="bi bi-envelope-check"> </span>
                @break

            @case('Declined Invite')
                <span class="bi bi-envelope-dash"> </span>
                @break

            @case('New comment')
                <span class="bi bi-card-text"> </span>
                @break

            @case('New poll')
                <span class="bi bi-list"> </span>
                @break

            @case('Closed Poll')

                @break
            @default
                {{$notification->notication_type}}
                @break
        @endswitch
    </div>
    <div class="col-sm-8 notification-text">
        @switch($notification->notification_type)
            @case('Disabled event')
                @include('partials.hyperlinks.event', ['event' => $notification->event])
                was disabled
                @break

            @case('Cancelled event')
                @include('partials.hyperlinks.event', ['event' => $notification->event])
                was cancelled
                @break

            @case('Join request')
                @include('partials.hyperlinks.user', ['user' => $notification->attendance_request->attendee])
                requested to join
                @include('partials.hyperlinks.event', ['event' => $notification->attendance_request->event])
                @break

            @case('Accepted request')
                @include('partials.hyperlinks.user', ['user' => $notification->attendance_request->event->organiser])
                accepted your request to join
                @include('partials.hyperlinks.event', ['event' => $notification->attendance_request->event])
                @break

            @case('Declined request')
                @include('partials.hyperlinks.user', ['user' => $notification->attendance_request->event->organiser])
                declined your request to join
                @include('partials.hyperlinks.event', ['event' => $notification->attendance_request->event])
                @break

            @case('Invite')
                @include('partials.hyperlinks.user', ['user' => $notification->attendance_request->event->organiser])
                invited you to
                @include('partials.hyperlinks.event', ['event' => $notification->attendance_request->event])
                @break

            @case('Accepted invite')
                @include('partials.hyperlinks.user', ['user' => $notification->attendance_request->attendee])
                accepted your invite to
                @include('partials.hyperlinks.event', ['event' => $notification->attendance_request->event])
                @break

            @case('Declined Invite')
                @include('partials.hyperlinks.user', ['user' => $notification->attendance_request->attendee])
                declined your invite to
                @include('partials.hyperlinks.event', ['event' => $notification->attendance_request->event])
                @break

            @case('New comment')
                @include('partials.hyperlinks.user', ['poll' => $notification->comment->commenter])
                commented on you event
                @include('partials.hyperlinks.poll', ['poll' => $notification->comment->event])
                @break

            @case('New poll')
                The poll
                @include('partials.hyperlinks.poll', ['poll' => $notification->poll])
                was created in the event
                @include('partials.hyperlinks.event', ['event' => $notification->poll->event])
                @break

            @case('Closed Poll')
                The poll
                @include('partials.hyperlinks.poll', ['poll' => $notification->poll])
                was closed in the event
                @include('partials.hyperlinks.event', ['event' => $notification->poll->event])
                @break

            @default
                Unknown notification
                @break
        @endswitch
    </div>
    <div class="col-sm-2 notification-date">
        {{$notification->date->diffForHumans()}}
    </div>
    <div class="col-sm-1">
        <div class="btn-group float-end">
            <span class="bi bi-three-dots-vertical clickableIcon" data-bs-toggle="dropdown" aria-expanded="false"> </span>
            <ul class="dropdown-menu">
                <li>
                    @if($notification->is_seen)
                        <div class="dropdown-item clickable"
                            id="markAsRead{{$notification->id}}"
                            onclick="notificationEdit({{$notification->id}}, 0)">
                            Mark as unread
                        </div>
                    @else
                        <div class="dropdown-item clickable"
                        id="markAsRead{{$notification->id}}"
                        onclick="notificationEdit({{$notification->id}}, 1)">Mark as read</div>
                    @endif
                </li>
                <li>
                    <div class="dropdown-item clickable"
                         onclick="notificationDelete({{$notification->id}})">
                        Delete
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
@empty
    <div id="emptyNotifications">No notifications to be displayed</div>
@endforelse
