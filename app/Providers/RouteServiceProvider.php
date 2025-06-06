<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // Configure rate limiting
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Apply rate limiting to inventory-related routes
        RateLimiter::for('inventory-api', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()?->id ?: $request->ip());
        });
        $this->routes(function () {
            // API Routes - explicitly load with api middleware
            Route::middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group(function () {
                    require base_path('routes/api.php');
                });

            // Web Routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
