<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportAPIController extends Controller
{
    public function getForm()
    {
        return view('partials.reports.form');
    }

    public function registerReport(Request $request, $type, $id)
    {
        return;
    }
}
