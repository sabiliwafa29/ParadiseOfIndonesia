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
            \Log::info('=== Google Callback Started ===');
            \Log::info('Full URL: ' . request()->fullUrl());
            \Log::info('Has code: ' . (request()->has('code') ? 'YES' : 'NO'));
            
            // Cek jika user membatalkan login
            if (request()->has('error')) {
                \Log::warning('Google OAuth Error: ' . request()->get('error'));
                return redirect()->route('login')
                    ->with('error', 'Google login was cancelled');
            }

            // Get user dari Google dengan stateless mode
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            \Log::info('Google user data retrieved successfully');
            \Log::info('Email: ' . $googleUser->getEmail());
            \Log::info('Name: ' . $googleUser->getName());

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Update existing user
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'name' => $googleUser->getName(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                ]);
                
                \Log::info('Existing user updated: ' . $user->email);
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
                
                \Log::info('New user created: ' . $user->email);
            }

            // Login user
            Auth::login($user, true); // true = remember me
            
            \Log::info('User successfully logged in: ' . $user->email . ' (Role: ' . $user->role . ')');

            // Redirect based on role
            if ($user->role === 'admin') {
                \Log::info('Redirecting admin to admin panel');
                return redirect()->intended(route('admin.dashboard'));
            }

            \Log::info('Redirecting user to dashboard');
            return redirect()->intended(route('home'));
            
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            \Log::error('Invalid State Exception (session issue): ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Session expired. Please try again.');
                
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            \Log::error('Google API Client Exception: ' . $e->getMessage());
            \Log::error('Response: ' . $e->getResponse()->getBody()->getContents());
            return redirect()->route('login')
                ->with('error', 'Google authentication failed. Please try again.');
                
        } catch (\Exception $e) {
            \Log::error('Google login exception: ' . $e->getMessage());
            \Log::error('Exception class: ' . get_class($e));
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->route('login')
                ->with('error', 'An error occurred during authentication. Please try again.');
        }
    }
}