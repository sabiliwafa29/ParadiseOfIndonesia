<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect(Request $request)
    {
        if ($request->has('return_to')) {
            session(['url.intended' => $request->return_to]);
        }

        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = $this->findOrCreateUser($googleUser);

            Auth::login($user, true);

            return $this->redirectBasedOnRole($user);
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please try again.');
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'An error occurred during authentication. Please try again.');
        }
    }

    protected function findOrCreateUser($googleUser): User
    {
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'name' => $googleUser->getName(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);
        }

        return $user;
    }

    protected function redirectBasedOnRole(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('login_success', true)
                ->with('user_name', $user->name);
        }

        return redirect()->route('home')
            ->with('login_success', true)
            ->with('user_name', $user->name);
    }
}