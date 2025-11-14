<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        // Cek jika ada parameter 'return_to' di URL
        if ($request->has('return_to')) {
            session(['url.intended' => $request->return_to]);
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        // Method 1: Jika menggunakan kolom 'role' di tabel users
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'))
                ->with('login_success', true)
                ->with('user_name', $user->name);
        }

        // Method 2: Jika menggunakan Spatie Permission (uncomment jika pakai)
        // if ($user->hasRole('admin')) {
        //     return redirect()->intended(route('admin.dashboard'))
        //         ->with('login_success', true)
        //         ->with('user_name', $user->name);
        // }

        // User biasa redirect ke home
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect ke home setelah logout
        return redirect('/');
    }
}