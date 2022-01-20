<span id="notificationCount" class="d-none">{{count($notifications)}}</span>
@forelse ($notifications as $notification)
<div id="notification{{$notification->id}}" class="notification d-flex w-100 p-2" seen="{{$notification->is_seen ? '1' : '0'}}">
    <div class="col-sm-1 d-flex align-items-center justify-content-center icon">
        @switch($notification->notification_type)
            @case('Disabled event')
                <!-- Event pusher done-->
                <span class="bi bi-calendar-x"> </span>
                @break

            @case('Cancelled event')
                <!-- Event pusher NOT DONE-->
                <span class="bi bi-calendar-x"> </span>
                @break

            @case('Join request')
                <!-- Event pusher NOT DONE-->
                <span class="bi bi-calendar-plus"> </span>
                @break

            @case('Accepted request')
                <!-- Event pusher NOT DONE-->
                <span class="bi bi-calendar-check"> </span>
                @break

            @case('Declined request')
                <!-- Event pusher NOT DONE-->
                <span class="bi bi-calendar-x"> </span>
                @break

            @case('Invite')
                <!-- Event pusher done-->
                <span class="bi bi-envelope-plus"> </span>
                @break

            @case('Accepted invite')
                <!-- Event pusher NOT DONE-->
                <span class="bi bi-envelope-check"> </span>
                @break

            @case('Declined Invite')
                <!-- Event pusher done-->
                <span class="bi bi-envelope-dash"> </span>
                @break

            @case('New comment')
                <!-- Event pusher DONE-->
                <span class="bi bi-card-text"> </span>
                @break

            @case('New poll')
                <!-- Event pusher NOT DONE-->
                <span class="bi bi-list"> </span>
                @break

            @case('Closed Poll')
                <!-- Event pusher not done-->
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
                which you were attending, was disabled
                @break

            @case('Cancelled event')
                @include('partials.hyperlinks.event', ['event' => $notification->event])
                was cancelled
                @break

            @case('Join request')
                @include('partials.hyperlinks.user', ['user' => $notification->attendanceRequest->attendee])
                requested to join
                @include('partials.hyperlinks.event', ['event' => $notification->attendanceRequest->event])
                @break

            @case('Accepted request')
                @include('partials.hyperlinks.user', ['user' => $notification->attendanceRequest->event->organizer])
                accepted your request to join
                @include('partials.hyperlinks.event', ['event' => $notification->attendanceRequest->event])
                @break

            @case('Declined request')
                @include('partials.hyperlinks.user', ['user' => $notification->attendanceRequest->event->organizer])
                declined your request to join
                @include('partials.hyperlinks.event', ['event' => $notification->attendanceRequest->event])
                @break

            @case('Invite')
                @include('partials.hyperlinks.user', ['user' => $notification->attendanceRequest->event->organizer])
                invited you to
                @include('partials.hyperlinks.event', ['event' => $notification->attendanceRequest->event])
                @break

            @case('Accepted invite')
                @include('partials.hyperlinks.user', ['user' => $notification->attendance_request->attendee])
                accepted your invite to
                @include('partials.hyperlinks.event', ['event' => $notification->attendanceRequest->event])
                @break

            @case('Declined Invite')
                @include('partials.hyperlinks.user', ['user' => $notification->attendanceRequest->attendee])
                declined your invite to
                @include('partials.hyperlinks.event', ['event' => $notification->attendanceRequest->event])
                @break

            @case('New comment')
                @include('partials.hyperlinks.user', ['user' => $notification->comment->author])
                commented on your event
                @include('partials.hyperlinks.event', ['event' => $notification->comment->event])
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
        <div class="btn-group float-end dropstart">
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
