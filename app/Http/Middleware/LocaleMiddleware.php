<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Services\LocationService;

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
        // Otomatis deteksi berdasarkan geolocation jika tidak ada preference
        else {
            $country = LocationService::detectCountry();
            $locale = $this->getLocaleFromCountry($country);
            // Simpan ke session untuk request selanjutnya
            Session::put('locale', $locale);
        }

        // Set locale
        App::setLocale($locale);

        return $next($request);
    }

    /**
     * Get locale code from country code
     */
    private function getLocaleFromCountry(string $country): string
    {
        return match($country) {
            'ID' => 'id',  // Indonesia
            'CN' => 'zh',  // China
            default => 'en', // International
        };
    }
}