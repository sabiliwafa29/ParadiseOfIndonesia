<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->role === 'admin' && $role === 'user') {
            return redirect()->route('admin.tours.index')
                ->with('error', 'Admin cannot access user pages.');
        }

        if ($user->role === 'user' && $role === 'admin') {
            return redirect()->route('home')
                ->with('error', 'Access denied. Admin area.');
        }

        if ($user->role === $role) {
            return $next($request);
        }

        return redirect()->route($user->role === 'admin' ? 'admin.tours.index' : 'home');
    }
}