<?php

namespace App\Http\Controllers\Notifications;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function get(Request $request)
    {
        $notifications = null;
        if ($request == null || $request->last != null) {
            $notifications = Notification::where('addressee', Auth::user()->id)->where('is_seen', 'false')->where('id', '>', $request->last)->orderByDesc('date')->get();
        } else {

            $notifications = Notification::where('addressee_id',  Auth::user()->id)->where('is_seen', 'false')->orderByDesc('date')->get();
        }
        return view('partials.notifications.list', ['notifications' => $notifications]);
    }
}
