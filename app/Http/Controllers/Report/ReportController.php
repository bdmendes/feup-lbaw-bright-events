<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::paginate(15);
        return view('pages.reports.browse', ["reports" => $reports->withQueryString()]);
    }
}
