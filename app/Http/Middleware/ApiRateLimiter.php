<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class ApiRateLimiter
{
    /**
     * Handle an incoming request.
     *
     * This middleware applies rate limiting to API requests.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get user ID or IP address for rate limiting
        $key = $request->user()?->id ?: $request->ip();

        // Define the limiter key
        $limiterKey = "api-{$request->path()}-{$key}";

        // Check if the request exceeds the rate limit
        if (RateLimiter::tooManyAttempts($limiterKey, 60)) {
            // Get the number of seconds until the user can try again
            $seconds = RateLimiter::availableIn($limiterKey);

            return response()->json([
                'message' => "Too many attempts. Please try again after {$seconds} seconds.",
                'retry_after' => $seconds
            ], 429);
        }

        // Increment the rate limiter hit counter
        RateLimiter::hit($limiterKey);

        // Add rate limit headers to the response
        $response = $next($request);

        $response->headers->add([
            'X-RateLimit-Limit' => 60,
            'X-RateLimit-Remaining' => RateLimiter::remaining($limiterKey, 60),
        ]);

        return $response;
    }
}
