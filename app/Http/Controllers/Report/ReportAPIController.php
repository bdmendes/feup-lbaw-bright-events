<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Report;
use App\Models\User;
use App\Models\Event;
use App\Models\Comment;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;
use Auth;

class ReportAPIController extends Controller
{
    public function getForm()
    {
        return view('partials.reports.form');
    }

    public function registerReport(Request $request, $type, $id)
    {
        $rules = [
            'motive' => ['required', Rule::in(['Sexual harassment', 'Violence or bodily harm', 'Nudity or explicit content', 'Hate speech', 'Other'])],

            'description' => ['required', 'string','max:1000']
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages = []);

        if ($validator->errors()->all() || !in_array($type, ['event', 'user', 'comment'])) {
            return response('Invalid input', 422)
                  ->header('Content-Type', 'text/plain');
        }
        
        $this->authorize('create', Report::class);
        
        $report = Report::create(['description' => $request->input('description'),
                        'report_motive' => $request->input('motive'),
                        'type' => $type,
                        'reported_comment_id' => $type === 'comment' ? $id : null,
                        'reported_user_id' => $type === 'user' ? $id : null,
                        'reported_event_id' => $type === 'event' ? $id : null]);

        if ($report== null) {
            return 'Could not create report';
        }
        
        return;
    }

    
    private function setHandler(Report $report)
    {
        if (is_null($report->handled_by_id)) {
            $report->handled_by_id = Auth::id();
            $report->save();
        }
    }

    public function markHandled(Request $request)
    {
        $report = Report::find($request->reportId);

        if (is_null($report)) {
            return abort(404, "Couldn't find report");
        }

        $this->authorize('markHandled', $report);

        $this->setHandler($report);

        return view('partials.reports.card', ['report' => $report]);
    }

    public function block(Request $request)
    {
        $report = Report::find($request->reportId);
        if (is_null($report)) {
            return abort(404, "Couldn't find report");
        }

        $this->authorize('block', $report);

        
        if (!is_null($report->reported_user_id)) {
            $user = User::find($report->reported_user_id);
            if (is_null($user)) {
                abort('404', 'User not found');
            }
        
            $user->is_blocked = true;
            $user->save();
        } else {
            if (!is_null($report->reported_event_id)) {
                $event = Event::find($report->reported_event_id);
                if (is_null($event)) {
                    abort('404', 'Event not found');
                }
        
                $event->is_disabled = true;
                $event->save();
            } else {
                abort(422, 'Unprocessable parameters');
            }
        }

        $this->setHandler($report);

        return view('partials.reports.card', ['report' => $report]);
    }

    public function delete(Request $request)
    {
        $report = Report::find($request->reportId);
        if (is_null($report)) {
            return abort(404, "Couldn't find report");
        }

        $this->authorize('delete', $report);

        if ($report->type == 'user') {
            $user = User::find($report->reported_user_id);
            if (isset($user)) {
                $user->delete();
            }
        } else {
            if ($report->type == 'comment') {
                $comment = Comment::find($report->reported_comment_id);
                if (isset($comment)) {
                    $comment->delete();
                }
            } else {
                abort(500, 'Internal server error');
            }
        }

        $this->setHandler($report);
        
        return view('partials.reports.card', ['report' => $report, 'request' => $request]);
    }
}
