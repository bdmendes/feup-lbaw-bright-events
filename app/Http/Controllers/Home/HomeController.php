<?php

namespace App\Http\Controllers\Home;

use App\Models\Event;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class HomeController extends Controller
{
    public function home()
    {
        $events = Event::all()->take(3);
        $users = User::all()->take(4);
        return view('pages.static.home', compact('events', 'users'));
    }

    public function redirect()
    {
        return redirect(route('home'));
    }
}
