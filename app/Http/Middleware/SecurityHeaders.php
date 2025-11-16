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

        // HSTS (HTTP Strict-Transport-Security)
        // Instructs browsers to always use HTTPS for this domain
        $response->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // X-Content-Type-Options
        // Prevents MIME type sniffing attacks
        $response->header('X-Content-Type-Options', 'nosniff');

        // X-Frame-Options
        // Prevents clickjacking attacks
        $response->header('X-Frame-Options', 'SAMEORIGIN');

        // X-XSS-Protection
        // Legacy XSS protection header (modern browsers use CSP)
        $response->header('X-XSS-Protection', '1; mode=block');

        // Referrer-Policy
        // Controls how much referrer information is shared
        $response->header('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions-Policy (formerly Feature-Policy)
        // Controls which browser features and APIs can be used
        $response->header('Permissions-Policy', implode(', ', [
            'geolocation=()' . (config('app.env') === 'production' ? '' : ', camera=(), microphone=()'),
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
        ]));

        // Content-Security-Policy
        // Comprehensive CSP to prevent XSS, injection, and other attacks
        $csp = $this->getContentSecurityPolicy($request);
        $response->header('Content-Security-Policy', $csp);

        // Additional hardening for API responses
        $response->header('X-Powered-By', ''); // Remove server info disclosure
        $response->header('Server', ''); // Remove server info disclosure

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
        $scriptSrcs[] = 'https://app.sandbox.midtrans.com';
        $connectSrcs[] = 'https://api.midtrans.com';
        $connectSrcs[] = 'https://api.sandbox.midtrans.com';
        $connectSrcs[] = 'https://app.midtrans.com'; // For source maps
        $connectSrcs[] = 'https://app.sandbox.midtrans.com'; // For source maps
        
        // Add OSRM for routing
        $connectSrcs[] = 'https://router.project-osrm.org';
        
        // Add unpkg CDN for Alpine.js and other libraries
        $scriptSrcs[] = 'https://unpkg.com';

        return implode('; ', [
            'default-src ' . implode(' ', ["'self'"]),
            'script-src ' . implode(' ', $scriptSrcs),
            'style-src ' . implode(' ', $styleSrcs),
            'img-src ' . implode(' ', $imgSrcs),
            'font-src ' . implode(' ', $fontSrcs),
            'connect-src ' . implode(' ', $connectSrcs),
            'media-src ' . implode(' ', ["'self'", 'https:']),
            'object-src ' . implode(' ', ["'none'"]),
            'frame-src ' . implode(' ', ["'self'", 'https://app.midtrans.com', 'https://app.sandbox.midtrans.com']),
            'base-uri ' . implode(' ', ["'self'"]),
            'form-action ' . implode(' ', ["'self'", 'https://app.midtrans.com', 'https://api.midtrans.com']),
            "upgrade-insecure-requests",
        ]);
    }
}
