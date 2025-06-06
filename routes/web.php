<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group.
 * |
 */

// Public routes (no authentication required)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/register', [App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Protected routes (authentication required)
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Barcode scanning route
    Route::get('/scan', function () {
        return view('scan');
    })->name('scan');

    // Section views
    Route::get('/section/product', function () {
        return view('section.product');
    })->name('section.product');

    // Inventory Management routes - protected with inventory.access middleware
    Route::middleware(['inventory.access'])->prefix('inventory')->group(function () {
        // Product routes
        Route::resource('products', ProductController::class);

        // Transaction routes
        Route::resource('transactions', TransactionController::class);

        // Reporting and stock management routes
        Route::get('/stock-levels', [ProductController::class, 'stockLevels'])->name('inventory.stock');
        Route::get('/activity-log', [TransactionController::class, 'activityLog'])->name('inventory.activity');
    });

    // Admin-only routes
    Route::middleware(['admin.access'])->prefix('admin')->group(function () {
        // User management
        Route::get('/users', function () {
            // This would typically be a UserController method
            return view('admin.users');
        })->name('admin.users');

        // System settings
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('admin.settings');

        // Activity logs for administrators
        Route::get('/logs', function () {
            return view('admin.logs');
        })->name('admin.logs');
    });
});
