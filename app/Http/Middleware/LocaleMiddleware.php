<?php

namespace App\Http\Middleware;

use App\Services\LocationService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $this->resolveLocale();
        App::setLocale($locale);

        return $next($request);
    }

    protected function resolveLocale(): string
    {
        if (Session::has('locale')) {
            return Session::get('locale');
        }

        if (auth()->check() && auth()->user()->locale) {
            return auth()->user()->locale;
        }

        $country = LocationService::detectCountry();

        return match($country) {
            'ID' => 'id',
            'CN' => 'zh',
            default => 'en',
        };
    }
}