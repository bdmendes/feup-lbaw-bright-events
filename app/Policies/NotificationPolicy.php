<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(?User $user, Notification $notification)
    {

        return $notification->addressee_id == $user->id;
    }

    public function delete(?User $user, Notification $notification)
    {

        return $notification->addressee_id == $user->id || $user->is_admin;
    }
}
