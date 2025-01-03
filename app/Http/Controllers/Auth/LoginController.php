<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Chat;

class LoginController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $chats = collect(); // Initialize as an empty collection for consistency

        if ($userId) {
            $chats = Chat::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('professional_id', $userId);
            })->orderBy('created_at', 'desc')->limit(5)->get();
        }

        return view('welcome', [
            'layout' => 'layouts.app',
            'chats' => $chats
        ]);
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
            $message->subject('Login with Magic Link');
            $message->from(config('app.sender'), config('app.name'));
        });

        return redirect()->route('magic.link.sent');
    }

    public function loginWithMagicLink($token)
    {
        $users = User::whereNotNull('magic_link_token')->get();

        foreach ($users as $user) {
            if (Hash::check($token, $user->magic_link_token)) {
                Auth::login($user);
                $user->magic_link_token = null;
                $user->save();
                return redirect()->intended('/');
            }
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
