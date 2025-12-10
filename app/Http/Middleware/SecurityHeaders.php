<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip adding security headers for StreamedResponse (file downloads, exports)
        // StreamedResponse doesn't support the header() method the same way
        if ($response instanceof \Symfony\Component\HttpFoundation\StreamedResponse) {
            return $response;
        }

        // HSTS (HTTP Strict-Transport-Security)
        // Instructs browsers to always use HTTPS for this domain
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // X-Content-Type-Options
        // Prevents MIME type sniffing attacks
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // X-Frame-Options
        // Prevents clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // X-XSS-Protection
        // Legacy XSS protection header (modern browsers use CSP)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy
        // Controls how much referrer information is shared
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy (formerly Feature-Policy)
        // Controls which browser features and APIs can be used
        // Allow geolocation for same-origin pages so browser geolocation API works.
        // If you want to restrict this later, change to 'geolocation=()' or control via config.
        $response->headers->set('Permissions-Policy', implode(', ', [
            'geolocation=(self)' . (config('app.env') === 'production' ? '' : ', camera=(), microphone=()'),
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
            // Allow unload only for same-origin (needed by some payment SDKs like PayPal)
            'unload=(self)',
        ]));

        // Content-Security-Policy
        // Comprehensive CSP to prevent XSS, injection, and other attacks
        $csp = $this->getContentSecurityPolicy($request);
        $response->headers->set('Content-Security-Policy', $csp);

        // Additional hardening for API responses
        $response->headers->set('X-Powered-By', ''); // Remove server info disclosure
        $response->headers->set('Server', ''); // Remove server info disclosure

        return $response;
    }

    /**
     * Generate Content-Security-Policy header value
     */
    private function getContentSecurityPolicy(Request $request): string
    {
        $isApi = $request->is('api/*');

        if ($isApi) {
            // Strict CSP for API endpoints
            return implode('; ', [
                "default-src 'none'",
                "frame-ancestors 'none'",
                "base-uri 'none'",
                "form-action 'none'",
            ]);
        }

        // More relaxed CSP for web application
        $cdnUrl = config('app.cdn_url') ? parse_url(config('app.cdn_url'), PHP_URL_HOST) : '';
        $appUrl = parse_url(config('app.url'), PHP_URL_HOST);

        $scriptSrcs = ["'self'", "'unsafe-inline'", "'unsafe-eval'"]; // unsafe-eval needed for Alpine.js
        $styleSrcs = ["'self'", "'unsafe-inline'"];
        $imgSrcs = ["'self'", 'data:', 'https:'];
        $fontSrcs = ["'self'", 'https:'];
        $connectSrcs = ["'self'"];
        $formActions = ["'self'"];
        
        // Add app URL explicitly to form-action (untuk workaround CSP 'self' issue)
        if ($appUrl) {
            $formActions[] = "https://{$appUrl}";
            $formActions[] = "http://{$appUrl}"; // fallback untuk development
        }
        
        // Tambahkan domain paradiseofindonesia.com secara explicit
        if (!in_array('https://paradiseofindonesia.com', $formActions)) {
            $formActions[] = 'https://paradiseofindonesia.com';
        }
        if (!in_array('http://paradiseofindonesia.com', $formActions)) {
            $formActions[] = 'http://paradiseofindonesia.com';
        }
        
        // Add Bunny Fonts
        $styleSrcs[] = 'https://fonts.bunny.net';
        $fontSrcs[] = 'https://fonts.bunny.net';

        // Add CDN if configured
        if ($cdnUrl) {
            $scriptSrcs[] = "https://{$cdnUrl}";
            $styleSrcs[] = "https://{$cdnUrl}";
            $imgSrcs[] = "https://{$cdnUrl}";
            $connectSrcs[] = "https://{$cdnUrl}";
        }

        // Add Midtrans domains for payment integration
        $scriptSrcs[] = 'https://app.midtrans.com';
        $scriptSrcs[] = 'https://app.midtrans.com';
    // PayPal SDK and assets
    $scriptSrcs[] = 'https://www.paypal.com';
    $scriptSrcs[] = 'https://www.paypal.com/sdk/js';
    $scriptSrcs[] = 'https://www.paypalobjects.com';
        $connectSrcs[] = 'https://api.midtrans.com';
        $connectSrcs[] = 'https://api.sandbox.midtrans.com';
        $connectSrcs[] = 'https://app.midtrans.com'; // For source maps
        $connectSrcs[] = 'https://app.midtrans.com'; // For source maps
    // PayPal API endpoints
    $connectSrcs[] = 'https://api-m.paypal.com';
    $connectSrcs[] = 'https://api-m.sandbox.paypal.com';
        $formActions[] = 'https://app.midtrans.com';
        $formActions[] = 'https://app.midtrans.com';
        $formActions[] = 'https://api.midtrans.com';
        
        // OSRM for routing
        $connectSrcs[] = 'https://router.project-osrm.org';
        
        // Add unpkg CDN for Alpine.js and other libraries
        $scriptSrcs[] = 'https://unpkg.com';

        // Ensure PayPal frame/connect domains are allowed (sandbox + production)
        $frameSrcs = ["'self'", 'https://app.midtrans.com', 'https://app.midtrans.com'];
        // PayPal frames (both www and non-www hosts, sandbox and prod)
        $frameSrcs[] = 'https://www.sandbox.paypal.com';
        $frameSrcs[] = 'https://sandbox.paypal.com';
        $frameSrcs[] = 'https://www.paypal.com';
        $frameSrcs[] = 'https://paypal.com';

        // Add PayPal logger/connect host (www.sandbox.paypal.com) to connect-src if not present
        if (!in_array('https://www.sandbox.paypal.com', $connectSrcs)) {
            $connectSrcs[] = 'https://www.sandbox.paypal.com';
        }
        if (!in_array('https://sandbox.paypal.com', $connectSrcs)) {
            $connectSrcs[] = 'https://sandbox.paypal.com';
        }
        if (!in_array('https://www.paypal.com', $connectSrcs)) {
            $connectSrcs[] = 'https://www.paypal.com';
        }

        // Deduplicate all source lists to avoid repeated hosts in the final CSP
        $scriptSrcs = array_values(array_unique($scriptSrcs));
        $styleSrcs = array_values(array_unique($styleSrcs));
        $imgSrcs = array_values(array_unique($imgSrcs));
        $fontSrcs = array_values(array_unique($fontSrcs));
        $connectSrcs = array_values(array_unique($connectSrcs));
        $formActions = array_values(array_unique($formActions));
        $frameSrcs = array_values(array_unique($frameSrcs));

        return implode('; ', [
            'default-src ' . implode(' ', ["'self'"]),
            'script-src ' . implode(' ', $scriptSrcs),
            'style-src ' . implode(' ', $styleSrcs),
            'img-src ' . implode(' ', $imgSrcs),
            'font-src ' . implode(' ', $fontSrcs),
            'connect-src ' . implode(' ', $connectSrcs),
            'media-src ' . implode(' ', ["'self'", 'https:']),
            'object-src ' . implode(' ', ["'none'"]),
            'frame-src ' . implode(' ', $frameSrcs),
            'base-uri ' . implode(' ', ["'self'"]),
            'form-action ' . implode(' ', $formActions),
            // Only upgrade insecure requests in production
            config('app.env') === 'production' ? "upgrade-insecure-requests" : "",
        ]);
    }
}
