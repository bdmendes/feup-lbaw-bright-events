<?php

namespace App\Policies;

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
        foreach ($event->attendances as $attendance) {
            if ($attendance->attendee_id == $user->id) {
                return true;
            }
        }
        return false;
    }

    public function create(Event $Event)
    {
        return Auth::check();
    }

    public function delete(User $user, Event $event)
    {
        return $user != null && ($user->id == $event->organizer_id || $user->is_admin);
    }

    public function block(User $user)
    {
        return $user->is_admin;
    }
}
