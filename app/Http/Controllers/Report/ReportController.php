<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.reports.reports');
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
