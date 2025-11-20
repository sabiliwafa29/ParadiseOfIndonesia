<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek dari session
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } 
        // Atau dari user preference (jika sudah login)
        elseif (auth()->check() && auth()->user()->locale) {
            $locale = auth()->user()->locale;
        } 
        // Default ke English untuk pengunjung pertama kali
        else {
            $locale = 'en';
        }

        // Set locale
        App::setLocale($locale);

        return $next($request);
    }
}