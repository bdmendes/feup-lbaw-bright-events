<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class ReportPolicy
{
    use HandlesAuthorization;

    
    public function create(User $user)
    {
        return Auth::check() && !Auth::user()->is_admin;
    }

    public function update(User $user, Report $report)
    {
        //
    }

    
    public function delete(User $user, Report $report)
    {
        //
    }


    public function forceDelete(User $user, Report $report)
    {
        //
    }
}
