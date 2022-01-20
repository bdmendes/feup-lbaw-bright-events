<?php

namespace App\Policies;

use App\Models\AttendanceRequest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EventPolicy
{
    use HandlesAuthorization;

    public function view(?User $user, Event $event)
    {
        if ($event->is_disabled) {
            return false;
        }
        if (!$event->is_private || ($user == null || $event->organizer_id == $user->id)) {
            return true;
        }
        if ($event->is_private && $user == null) {
            return false;
        }
        /*
        foreach ($event->attendances as $attendance) {
            if ($attendance->attendee_id == $user->id) {
                return true;
            }
        }
        */
        return true;
    }

    public function create(Event $Event)
    {
        return Auth::check();
    }

    public function delete(User $user, Event $event)
    {
        return $user != null && $user->id == $event->organizer_id;
    }

    public function joinRequest(?User $user, Event $event)
    {
        if (!$event->is_private) {
            return false;
        }
        foreach ($event->attendances as $attendance) {
            if ($attendance->attendee_id == $user->id)
                return false;
        }
        return true;
    }

    public function acceptJoinRequest(?User $user, Event $event)
    {

        if ($event->organizer_id != Auth::id()) {
            return false;
        }


        return true;
    }
}
