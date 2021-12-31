<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::search($request->query('global'));
        return view('pages.users.browse', ['users' => $users->paginate($request->size ?? 8)->withQueryString(), 'request' => $request]);
    }

    public function show($username)
    {
        $user = User::where('username', $username)->get()->first();
        if (is_null($user)) {
            abort('404', 'User not found');
        }
        return view('pages.users.view', [
            'user' => $user,
            'attended_events' => $user->attended_events(),
        ]);
    }

    public function edit($username)
    {
        $user = User::where('username', $username)->get()->first();
        if (is_null($user)) {
            abort('404', 'User not found');
        }
        return view('pages.users.edit', [
            'user' => $user,
        ]);
    }

    public function editUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'username' => 'string|max:255',
            'bio' => 'nullable|string|max:255',
            'email' => 'string|email|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'string|in:Female,Male,Other',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if ($request->name != $user->name) {
            $user->name = $request->name;
        }
        
        if ($request->username != $user->username) {
            $find = User::where('username', $request->username)->get()->first();
            if (!is_null($find)) {
                $validator->getMessageBag()->add('username', 'Username already in use');
                return redirect()->route('editProfile', ['username' => Auth::user()->username])->withErrors($validator)->withInput();
            }
            $user->username = $request->username;
        }

        if (!is_null($request->bio) && $request->bio != $user->bio) {
            $user->bio = $request->bio;
        }

        if ($request->email != $user->email) {
            $find = User::where('email', $request->email)->get()->first();
            if (!is_null($find)) {
                $validator->getMessageBag()->add('email', 'Email already in use');
                return redirect()->route('editProfile', ['username' => Auth::user()->username])->withErrors($validator)->withInput();
            }
            $user->email = $request->email;
        }

        if ($request->gender != $user->gender) {
            $user->gender = $request->gender;
        }

        if (!is_null($request->birth_date) && $request->birth_date != $user->birth_date) {
            $user->birth_date = $request->birth_date;
        }

        if (!is_null($request->password) && $request->password != $user->password) {
            if (is_null($request->confirm_password)) {
                $validator->getMessageBag()->add('confirm_password', 'Please confirm your password');
                return redirect()->route('editProfile', ['username' => Auth::user()->username])->withErrors($validator)->withInput();
            } elseif ($request->password != $request->confirm_password) {
                $validator->getMessageBag()->add('confirm_password', 'Passwords do not match');
                return redirect()->route('editProfile', ['username' => Auth::user()->username])->withErrors($validator)->withInput();
            }
            $user->password = bcrypt($request->password);
        } elseif (is_null($request->password) && !is_null($request->confirm_password)) {
            $validator->getMessageBag()->add('password', 'Please input a password before confirming it.');
            return redirect()->route('editProfile', ['username' => Auth::user()->username])->withErrors($validator)->withInput();
        }

        $user->save();

        return redirect()->route('profile', ['username' => Auth::user()->username]);
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
