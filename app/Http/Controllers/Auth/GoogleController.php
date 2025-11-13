<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        if ($request->has('return_to')) {
            session(['url.intended' => $request->return_to]);
        }

        return Socialite::driver('google')
                                ->with(['prompt' => 'select_account'])
                                ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                ]
            );

            $user->update(['google_id' => $googleUser->getId()]);

            Auth::login($user, true);

            \Log::info('User logged in via Google:', [
                'email' => $user->email,
                'role' => $user->role,
            ]);

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.tours.index'));
            }

            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            \Log::error('Google login failed: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Google authentication failed.');
        }
    }

}
