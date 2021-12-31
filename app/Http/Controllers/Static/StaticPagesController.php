<?php

namespace App\Http\Controllers\Static;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class StaticPagesController extends Controller
{
    public function faq()
    {
        return view('pages.static.faq');
    }

    public function about()
    {
        return view('pages.static.about');
    }
    
    public function contact()
    {
        return view('pages.static.contact');
    }
}
