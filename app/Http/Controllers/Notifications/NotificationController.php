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
        if (!Auth::check()) {
            abort(403, 'Unidentified user');
        }
        if ($request == null || $request->last != null) {
            $notifications = Notification::where('addressee_id', Auth::user()->id)->where('is_seen', 'false')->where('id', '>', $request->last)->orderByDesc('id')->get();
        } else {
            $notifications = Notification::where('addressee_id', Auth::user()->id)->where('is_seen', 'false')->orderByDesc('id')->get();
        }
        return view('partials.notifications.list', ['notifications' => $notifications]);
    }

    public function getPast(Request $request)
    {
        $notifications = Notification::where('addressee_id', Auth::user()->id)->where('is_seen', 'true')->orderByDesc('date')->offset($request->get('offset'))->limit($request->get('size'))->get();
        return view('partials.notifications.list', ['notifications' => $notifications]);
    }

    public function read(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required|array',
            'ids.*' => 'required|int'
        ]);
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            $notification = Notification::find($id);
            $this->authorize('edit', $notification);
            $notification->is_seen = true;
            $notification->save();
        }
    }

    public function edit(Request $request, $id)
    {
        $this->validate($request, [
            'is_seen' => 'required'
        ]);
        $notification = Notification::find($id);
        $this->authorize('edit', $notification);
        $notification->is_seen = $request->get('is_seen');
        $notification->save();
    }

    public function delete(Request $request, $id)
    {
        $notification = Notification::find($id);
        $this->authorize('delete', $notification);
        $notification->delete();
    }
}
