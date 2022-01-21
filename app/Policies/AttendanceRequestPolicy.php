<?php

namespace App\Policies;

use App\Models\AttendanceRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AttendanceRequestPolicy
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



    public function acceptJoinRequest(?User $user, AttendanceRequest $request)
    {

        return true;
    }

    public function answerInvite(?User $user, AttendanceRequest $request)
    {
        return $request->is_invite && $user->id == $request->attendee_id;
    }
}
