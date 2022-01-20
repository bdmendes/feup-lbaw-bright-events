<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Report;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

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

        if ($validator->errors()->all()) {
            return response('Invalid input', 422)
                  ->header('Content-Type', 'text/plain');
        }
        
        $this->authorize('create', Report::class);
        
        $report = Report::create(['description' => $request->input('description'),
                        'report_motive' => $request->input('motive'),
                        'reported_comment_id' => $type === 'comment' ? $id : null,
                        'reported_user_id' => $type === 'user' ? $id : null,
                        'reported_event_id' => $type === 'event' ? $id : null]);

        if ($report== null) {
            return 'Could not create report';
        }
        
        return;
    }
}
