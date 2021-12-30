<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.users');
    }

    public function show($username)
    {
        $user = User::where('username', $username)->get()->first();
        if (is_null($user)) {
            abort('404', 'User not found');
        }
        return view('pages.user.view', [
            'user' => $user,
            'attended_events' => $user->attended_events(),
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', [
            'user' => $user,
        ]);
    }

    public function create($request)
    {
        $this->validate($request, [
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
            'name' => 'required',
            'gender' => 'required',
        ]);

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'password' => Crypt::encrypt($request->password),
            'name' => $request->name,
            'gender' => $request->gender,
        ]);

        return redirect()->route('home');
    }
}
