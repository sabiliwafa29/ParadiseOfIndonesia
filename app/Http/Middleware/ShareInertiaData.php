<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Helpers\LanguageHelper;

class ShareInertiaData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illumina   te\Http\Response)  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        $locale = $request->query('locale') ?? app()->getLocale();
        app()->setLocale($locale);

        Inertia::share([
            'user' => Auth::check() ? Auth::user() : null,
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'app' => [
                'name' => config('app.name'),
                'locale' => app()->getLocale(),
                'languages' => LanguageHelper::getLanguages(),
                'currency' => LanguageHelper::getCurrencySymbol(),
            ],
        ]);

        return $next($request);
    }

    /**
     * Terminate an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response)  $next
     * @return \Illuminate\Http\Response
     */
    public function terminate(Request $request, $response)
    {
        //
    }
}
