<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Jika yang login admin tapi akses halaman user
        if ($user->role === 'admin' && $role === 'user') {
            return redirect()->route('admin.tours.index')
                ->with('error', 'Admin tidak dapat mengakses halaman user');
        }

        // Jika yang login user tapi akses halaman admin
        if ($user->role === 'user' && $role === 'admin') {
            return redirect()->route('home')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin');
        }

        // Jika role sesuai, lanjutkan request
        if ($user->role === $role) {
            return $next($request);
        }

        // Jika role tidak sesuai, redirect ke halaman yang sesuai
        return redirect()->route($user->role === 'admin' ? 'admin.tours.index' : 'home');
    }
}