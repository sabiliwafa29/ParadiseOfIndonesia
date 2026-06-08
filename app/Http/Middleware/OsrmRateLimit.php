<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class OsrmRateLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Create rate limiter key based on IP address
        $key = 'osrm_api_' . $request->ip();

        // Allow 10 requests per minute per IP
        $maxAttempts = 10;
        $decayMinutes = 1;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = RateLimiter::availableIn($key);

            Log::warning('OSRM API rate limit exceeded', [
                'ip' => $request->ip(),
                'retry_after_seconds' => $retryAfter,
                'endpoint' => $request->path()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => $retryAfter,
                'limit' => $maxAttempts,
                'decay_minutes' => $decayMinutes
            ], 429, [
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Reset' => now()->addSeconds($retryAfter)->timestamp,
                'Retry-After' => $retryAfter
            ]);
        }

        // Record the attempt
        RateLimiter::hit($key, $decayMinutes * 60);

        // Add rate limit headers to successful responses
        $response = $next($request);

        if ($response instanceof Response) {
            $remaining = RateLimiter::remaining($key, $maxAttempts);
            $resetTime = RateLimiter::availableAt($key);

            $response->headers->set('X-RateLimit-Limit', $maxAttempts);
            $response->headers->set('X-RateLimit-Remaining', $remaining);
            $response->headers->set('X-RateLimit-Reset', $resetTime);
        }

        return $response;
    }
}
