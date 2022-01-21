<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

use App\Mail\RecoverPasswordMail;
use Illuminate\Support\Facades\Mail;
use Str;
use Hash;
use Password;

class RecoverController extends Controller
{
    public function showRecoverPasswordForm()
    {
        return view('auth.recover');
    }

    public function submitRecoverPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|confirmed'
        ]);
        /*         $user = User::where('email', $request->email)->first();
                if ($user == null) {
                    return back()->with(['error' => 'Email not found in the database']);
                } */
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
                ? back()->with(['message' => 'We have sent you an email.'])
                : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPasswordForm(Request $request)
    {
        return view('auth.reset', ['token' => $request->token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
            }
        );
        return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }
}
