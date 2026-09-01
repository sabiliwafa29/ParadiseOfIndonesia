<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    protected const SECURITY_HEADERS = [
        'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains; preload',
        'X-Content-Type-Options' => 'nosniff',
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-XSS-Protection' => '1; mode=block',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof \Symfony\Component\HttpFoundation\StreamedResponse) {
            return $response;
        }

        $this->applySecurityHeaders($response);
        $this->applyPermissionsPolicy($response);
        $this->applyContentSecurityPolicy($response, $request);

        return $response;
    }

    protected function applySecurityHeaders($response): void
    {
        foreach (self::SECURITY_HEADERS as $header => $value) {
            $response->headers->set($header, $value);
        }

        $response->headers->set('X-Powered-By', '');
        $response->headers->set('Server', '');
    }

    protected function applyPermissionsPolicy($response): void
    {
        $isProduction = config('app.env') === 'production';
        $cameraMicrophone = $isProduction ? '' : ', camera=(), microphone=()';

        $permissionsPolicy = implode(', ', [
            'geolocation=(self)' . $cameraMicrophone,
            'usb=()',
            'magnetometer=()',
            'gyroscope=()',
            'accelerometer=()',
        ]);

        $response->headers->set('Permissions-Policy', $permissionsPolicy);
    }

    protected function applyContentSecurityPolicy($response, Request $request): void
    {
        $csp = $this->buildContentSecurityPolicy($request);
        $response->headers->set('Content-Security-Policy', $csp);
    }

    protected function buildContentSecurityPolicy(Request $request): string
    {
        if ($request->is('api/*')) {
            return implode('; ', [
                "default-src 'none'",
                "frame-ancestors 'none'",
                "base-uri 'none'",
                "form-action 'none'",
            ]);
        }

        return $this->buildWebCsp($request);
    }

    protected function buildWebCsp(Request $request): string
    {
        $sources = $this->resolveCspSources($request);

        return implode('; ', [
            'default-src ' . implode(' ', $sources['self']),
            'script-src ' . implode(' ', $sources['script']),
            'style-src-elem ' . implode(' ', $sources['style']),
            'style-src ' . implode(' ', $sources['style']),
            'img-src ' . implode(' ', $sources['img']),
            'font-src ' . implode(' ', $sources['font']),
            'connect-src ' . implode(' ', $sources['connect']),
            'media-src ' . implode(' ', $sources['media']),
            'object-src ' . implode(' ', $sources['object']),
            'frame-src ' . implode(' ', $sources['frame']),
            'base-uri ' . implode(' ', $sources['self']),
            'form-action ' . implode(' ', $sources['form']),
            config('app.env') === 'production' ? "upgrade-insecure-requests" : "",
        ]);
    }

    protected function resolveCspSources(Request $request): array
    {
        $script = ["'self'", "'unsafe-inline'", "'unsafe-eval'"];
        $style = ["'self'", "'unsafe-inline'"];
        $img = ["'self'", 'data:', 'https:'];
        $font = ["'self'", 'https:'];
        $connect = ["'self'"];
        $media = ["'self'", 'https:'];
        $object = ["'none'"];
        $frame = [];
        $form = ["'self'"];

        $isProduction = config('app.env') === 'production';
        $appUrl = parse_url((string) config('app.url'), PHP_URL_HOST);
        $cdnUrl = parse_url((string) config('app.cdn_url'), PHP_URL_HOST);

        if (!$isProduction) {
            $viteOrigins = ['http://127.0.0.1:5173', 'http://127.0.0.1:5174'];
            $wsOrigins = ['ws://127.0.0.1:5173', 'ws://127.0.0.1:5174'];

            foreach ($viteOrigins as $origin) {
                $script[] = $origin;
                $style[] = $origin;
                $connect[] = $origin;
            }
            foreach ($wsOrigins as $origin) {
                $connect[] = $origin;
            }
        }

        if ($appUrl) {
            $form[] = "https://{$appUrl}";
            $form[] = "http://{$appUrl}";
            $form[] = 'https://paradiseofindonesia.com';
            $form[] = 'http://paradiseofindonesia.com';
        }

        $style[] = 'https://fonts.bunny.net';
        $font[] = 'https://fonts.bunny.net';

        if ($cdnUrl) {
            $script[] = "https://{$cdnUrl}";
            $style[] = "https://{$cdnUrl}";
            $img[] = "https://{$cdnUrl}";
            $connect[] = "https://{$cdnUrl}";
        }

        $this->addMidtransSources($script, $connect, $form, $frame);
        $this->addPaypalSources($script, $connect);
        $this->addOsrmSource($connect);
        $this->addUnpkgSource($script);

        $script = array_values(array_unique($script));
        $style = array_values(array_unique($style));
        $img = array_values(array_unique($img));
        $font = array_values(array_unique($font));
        $connect = array_values(array_unique($connect));
        $form = array_values(array_unique($form));
        $frame = array_values(array_unique($frame));

        return [
            'self' => ["'self'"],
            'script' => $script,
            'style' => $style,
            'img' => $img,
            'font' => $font,
            'connect' => $connect,
            'media' => $media,
            'object' => $object,
            'frame' => $frame,
            'form' => $form,
        ];
    }

    protected function addMidtransSources(array &$script, array &$connect, array &$form, array &$frame): void
    {
        $script[] = 'https://app.midtrans.com';
        $script[] = 'https://app.sandbox.midtrans.com';
        $connect[] = 'https://api.midtrans.com';
        $connect[] = 'https://api.sandbox.midtrans.com';
        $connect[] = 'https://app.midtrans.com';
        $connect[] = 'https://app.sandbox.midtrans.com';
        $form[] = 'https://app.midtrans.com';
        $form[] = 'https://app.sandbox.midtrans.com';
        $form[] = 'https://api.midtrans.com';
        $form[] = 'https://api.sandbox.midtrans.com';
        $frame[] = "'self'";
        $frame[] = 'https://app.midtrans.com';
        $frame[] = 'https://app.sandbox.midtrans.com';
    }

    protected function addPaypalSources(array &$script, array &$connect): void
    {
        $script[] = 'https://www.paypal.com';
        $script[] = 'https://www.paypal.com/sdk/js';
        $script[] = 'https://www.paypalobjects.com';
        $connect[] = 'https://api-m.paypal.com';
        $connect[] = 'https://api-m.sandbox.paypal.com';

        if (!in_array('https://www.sandbox.paypal.com', $connect)) {
            $connect[] = 'https://www.sandbox.paypal.com';
        }
        if (!in_array('https://sandbox.paypal.com', $connect)) {
            $connect[] = 'https://sandbox.paypal.com';
        }
        if (!in_array('https://www.paypal.com', $connect)) {
            $connect[] = 'https://www.paypal.com';
        }

        $script[] = 'https://www.sandbox.paypal.com';
        $script[] = 'https://sandbox.paypal.com';
        $script[] = 'https://www.paypal.com';
        $script[] = 'https://paypal.com';
    }

    protected function addOsrmSource(array &$connect): void
    {
        $connect[] = 'https://router.project-osrm.org';
    }

    protected function addUnpkgSource(array &$script): void
    {
        $script[] = 'https://unpkg.com';
    }
}