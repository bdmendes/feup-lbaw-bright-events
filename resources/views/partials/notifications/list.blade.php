@foreach ($notifications as $notification)
<div class="notification d-flex w-100 p-2">
    <div>{{($notification->notification_type == 'New poll')}}</div>
    <div class="col-sm-1">
        @if($notification->notification_type == 'New poll')
            Funcionou!!
        @endif
        @switch($notification->notification_type)
            @case('Disabled event')
                The event <a href="events/{{$notification->event_id}}" >{{$notification->event->title}}</a> was disabled
                @break
            @case('Cancelled event')
                The event <a href="events/{{$notification->event_id}}" >{{$notification->event->title}}</a> was cancelled
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
    <div class="col-sm-9 notification-text">
        @switch($notification->notification_type)
            @case('Disabled event')
                The event <a href="events/{{$notification->event_id}}" >{{$notification->event->title}}</a> was disabled
                @break
            @case('Cancelled event')
            The event <a href="events/{{$notification->event_id}}" >{{$notification->event->title}}</a> was cancelled
                @break
            @case('Join request')
                blabla
                @break
            @case('Accepted request')
                blabla
                @break
            @case('Declined request')
                blabla
                @break
            @case('Invite')
                blabla
                @break
            @case('Accepted invite')
                blabla
                @break
            @case('Declined Invite')
                bla bla
                @break
            @case('New comment')
                    <a href="users/{{$notification->comment->commenter->id}}">{{$notification->commenter->name}} </a> commented on you event <a href="events/{{$notification->poll->event->id}}">{{$notification->poll->event->title}} </a>
                @break
            @case('New poll')
                The poll <a title="{{$notification->poll->description}}">{{$notification->poll->title}}</a>was created in the event <a href="events/{{$notification->poll->event->id}}">{{$notification->poll->event->title}} </a>
                @break
            @case('Closed Poll')
                The poll <a title="{{$notification->poll->description}}">{{$notification->poll->title}}</a>was closed in the event <a href="events/{{$notification->poll->event->id}}">{{$notification->poll->event->title}} </a>
                @break
            @default
                Unknown notification
                @break
        @endswitch
        {{$notification->notification_type}}
    </div>
    <div class="col-sm-2 notification-date">

    </div>
</div>
@endforeach
