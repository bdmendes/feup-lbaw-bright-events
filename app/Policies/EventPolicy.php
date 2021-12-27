<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EventPolicy
{
    use HandlesAuthorization;


    public function view(User $user, Event $event)
    {
        if ($event->is_private) {
            //TODO later
        }
        // Anyone can see an event if it's public
        return true;
    }

    public function create(Event $Event)
    {
        return Auth::check();
    }
}
