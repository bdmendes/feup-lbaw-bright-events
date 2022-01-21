<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('showDash', Report::class);

        
        
        if ($request->filled('sort_by')) {
            if ($request->query('order') == 'descending') {
                $reports = Report::orderBy($request->query('sort_by'), 'desc');
            } else {
                $reports = Report::orderBy($request->query('sort_by'), 'asc');
            }
        } else {
            $reports = Report::orderBy('date', 'desc');
        }

        if ($request->filled('filter')) {
            if ($request->query('filter') == 'handled') {
                $reports = $reports->whereNotNull('handled_by_id');
            } else {
                $reports = $reports->whereNull('handled_by_id');
                ;
            }
        }
        return view('pages.reports.browse', ['reports' => $reports->paginate(10)->withQueryString(), 'request' => $request]);
    }
}
