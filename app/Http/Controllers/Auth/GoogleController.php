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

        // Gunakan stateless untuk menghindari masalah session
        return Socialite::driver('google')
                        ->stateless()
                        ->redirect();
    }

    public function callback()
    {
        try {
            // Get user dari Google dengan stateless mode
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update existing user
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);

            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'user', // Default role
                    'email_verified_at' => now(),
                ]);
            }

            // Login user
            Auth::login($user, true); // true = remember me

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('login_success', true)
                    ->with('user_name', $user->name);
            }

            // ⭐ LANGSUNG KE HOME, BUKAN KE DASHBOARD
            return redirect()->route('home')
                ->with('login_success', true)
                ->with('user_name', $user->name);
            
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
}