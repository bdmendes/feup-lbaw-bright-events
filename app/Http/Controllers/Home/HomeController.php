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
        $events = $this->trendingEvents();
        $users = $this->trendingOrganizers();
        return view('pages.home', compact('events', 'users'));
    }

    protected function trendingEvents()
    {
        $events = Event::all();
        $events = $events->map(function ($item, $key) {
            return ['score' => $item->score(), 'event' => $item];
        });

        
        $events = $events->sort()->reverse()->take(3);
        $events = $events->map(function ($item, $key) {
            return $item['event'];
        });
        return $events;
    }

    protected function trendingOrganizers()
    {
        $orgs = User::where('is_admin', 'false')->get();
        $orgs = $orgs->map(function ($item, $key) {
            return ['score' => $item->score(), 'event' => $item];
        });

        
        $orgs = $orgs->sort()->reverse()->take(3);
        $orgs = $orgs->map(function ($item, $key) {
            return $item['event'];
        });
        return $orgs;
    }

    public function redirect()
    {
        return redirect(route('home'));
    }
}
