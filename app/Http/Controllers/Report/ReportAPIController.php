<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportAPIController extends Controller
{
    public function reportEvent()
    {
        dd('report event');
    }

    public function reportUser()
    {
        dd('report user');
    }

    public function reportComment()
    {
        dd('report comment');
    }

    public function getReports()
    {
        dd('reports list');
    }

    public function show()
    {
        dd('get report details');
    }
}
