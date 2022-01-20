<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Auth;

class ReportPolicy
{
    use HandlesAuthorization;

    public function showDash(User $user)
    {
        return Auth::user()->is_admin;
    }

    
    public function create(User $user)
    {
        return Auth::check();
    }

    public function markHandled(User $user, Report $report)
    {
        return Auth::user()->is_admin && !$report->handled_by_id;
    }

    public function block(User $user, Report $report)
    {
        if (!Auth::user()->is_admin) {
            return false;
        }

        if ($report->reported_user_id) {
            return $report->reportedUser()->is_blocked;
        }
        if ($report->reported_event_id) {
            return $report->reportedEvent()->is_disabled;
        }

        return false;
    }

    
    public function delete(User $user, Report $report)
    {
        if (!Auth::user()->is_admin) {
            return false;
        }

        if ($report->reported_user_id) {
            return $report->reportedUser()->is_blocked;
        }
        if ($report->reported_comment_id) {
            return $report->reportedComment()->is_disabled;
        }

        return false;
    }
}
