<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the user has admin access.
     * In a real application, this would typically check the user's role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verify the user is authenticated
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
            }
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        // Check if user is an admin
        // In a real application, you would check the user's role or permissions
        // For example: if (!$request->user()->hasRole('admin'))
        if (!$this->isAdmin($request->user())) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses admin');
        }

        return $next($request);
    }

    /**
     * Determine if the user is an admin.
     * Checks the is_admin flag if present, otherwise falls back to email check.
     */
    protected function isAdmin($user): bool
    {
        // Jika kolom is_admin sudah ada di database, gunakan itu
        if (isset($user->is_admin)) {
            return (bool) $user->is_admin;
        }

        // Fallback ke metode lama jika kolom is_admin belum ada
        // Atau jika is_admin memang ada tetapi nilainya false, cek email sebagai tambahan
        return str_contains($user->email, 'admin');
    }
}
