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
        // List locale yang tersedia
        $availableLocales = ['en', 'id', 'zh'];
        
        // Cek dari session
        if (Session::has('locale') && in_array(Session::get('locale'), $availableLocales)) {
            $locale = Session::get('locale');
        } else {
            // Default locale
            $locale = config('app.locale', 'en');
        }

        // Set locale
        App::setLocale($locale);

        return $next($request);
    }
}