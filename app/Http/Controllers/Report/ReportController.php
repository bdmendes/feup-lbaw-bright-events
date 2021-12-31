<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy('date', 'desc')->get();
        return view('pages.reports.reports', ["reports" => $reports]);
    }

    public function show()
    {
        dd('report page');
    }

    public function execute()
    {
        dd('take action');
    }
}
