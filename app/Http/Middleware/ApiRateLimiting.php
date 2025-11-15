<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Symfony\Component\HttpFoundation\Response;

class ApiRateLimiting extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $limit = null, $decay = null): Response
    {
        // Determine rate limit based on endpoint
        $limits = $this->getApiRateLimits($request);

        foreach ($limits as $maxAttempts => $decaySeconds) {
            $response = $this->handleRequest(
                $request,
                $next,
                $maxAttempts,
                $decaySeconds
            );

            if ($this->hasTooManyAttempts($request, $maxAttempts, $decaySeconds)) {
                return $this->buildException($request, $maxAttempts, $decaySeconds);
            }
        }

        return $next($request);
    }

    /**
     * Get rate limits based on API endpoint and method
     */
    private function getApiRateLimits(Request $request): array
    {
        $path = $request->path();
        $method = $request->method();

        // Authentication endpoints: 5 attempts per minute per IP
        if (preg_match('/^api\/(login|register)/', $path)) {
            return [5 => 60];
        }

        // Booking endpoints: 20 per minute per user, 100 per hour
        if (preg_match('/^api\/bookings/', $path)) {
            if ($request->user()) {
                return [20 => 60, 100 => 3600];
            }
            return [10 => 60];
        }

        // Payment notification webhook: 100 per minute (from Midtrans servers)
        if (preg_match('/^api\/midtrans\/notification/', $path)) {
            return [100 => 60];
        }

        // Location search: 30 per minute per IP
        if (preg_match('/^api\/locations/', $path)) {
            return [30 => 60];
        }

        // Distance calculation (OSRM): 20 per minute per IP
        if (preg_match('/^api\/distance/', $path)) {
            return [20 => 60];
        }

        // Health check endpoints: 60 per minute
        if (preg_match('/^api\/health/', $path)) {
            return [60 => 60];
        }

        // Default: 60 per minute per IP
        return [60 => 60];
    }

    /**
     * Resolve request signature for rate limiting
     */
    protected function resolveRequestSignature($request)
    {
        // For authenticated users, use user ID to allow higher limits
        if ($request->user()) {
            return sha1('api-rate-limit:' . $request->user()->id);
        }

        // For unauthenticated, use IP address
        return $this->getClientIp($request);
    }

    /**
     * Get the client IP address, respecting X-Forwarded-For for proxies
     */
    private function getClientIp(Request $request): string
    {
        // In production, trust X-Forwarded-For from known proxies (configured in TrustProxies)
        if ($request->header('X-Forwarded-For')) {
            $ips = array_map('trim', explode(',', $request->header('X-Forwarded-For')));
            return reset($ips);
        }

        return $request->ip();
    }
}
