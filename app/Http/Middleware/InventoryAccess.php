<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class InventoryAccess
{
    /**
     * Handle an incoming request.
     *
     * This middleware controls access to inventory management features.
     * It can be extended to check user roles and permissions as well.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verify the user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu untuk mengakses fitur inventory');
        }

        // Add additional authorization checks here if needed
        // For example, check if the user has the right role/permission

        return $next($request);
    }
}
