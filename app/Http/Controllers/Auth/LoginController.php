<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function index()
    {
        return view('welcome')->with('layout', 'layouts.app');
    }

    public function sendMagicLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make(Str::random(8)) // Use Hash::make to hash the password

            ]
        );

        $token = Str::random(60);
        $user->magic_link_token = Hash::make($token);
        $user->save();

        $link = route('login.magic.link', ['token' => $token]);

        Mail::send('auth.emails.magic-link', ['link' => $link], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Your Magic Login Link');
        });

        return redirect()->route('magic.link.sent')->with('status', 'If your email is registered, you will receive a magic link.');
    }

    public function loginWithMagicLink($token)
    {
        $user = User::whereNotNull('magic_link_token')->first();

        if ($user && Hash::check($token, $user->magic_link_token)) {
            Auth::login($user);
            $user->magic_link_token = null;
            $user->save();
            return redirect()->intended('/');
        }

        return redirect('/')->withErrors(['token' => 'Invalid or expired magic link.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
