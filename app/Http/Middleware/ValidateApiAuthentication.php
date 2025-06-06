<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class ValidateApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the user is properly authenticated for API access.
     * It extends the basic Sanctum authentication with additional validation.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check for API token authentication
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Valid API token required.',
                ], 401);
            }
            throw new AuthenticationException('Unauthenticated. Valid API token required.');
        }

        // Check token capabilities/abilities if needed
        // if ($request->user()->tokenCan('specific-ability')) {
        //     // Allow access
        // }

        // Add user info to request for logging purposes
        $request->headers->add([
            'X-Authenticated-User' => $request->user()->id,
            'X-Authenticated-Role' => $request->user()->email  // In a real app, this would be the user's role
        ]);

        // Continue with the request
        return $next($request);
    }
}
