<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Api\BarcodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Basic test route - accessible at /api/test
Route::get('test', function () {
    return response()->json(['message' => 'API is working!']);
});

// Route for barcode checking - publicly accessible
Route::post('check-barcode', [BarcodeController::class, 'checkBarcode']);

// API v1 routes grouping
Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth routes
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/user', [AuthController::class, 'user']);

        // Products API
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'apiIndex']);
            Route::post('/', [ProductController::class, 'apiStore']);
            Route::get('/{product}', [ProductController::class, 'apiShow']);
            Route::put('/{product}', [ProductController::class, 'apiUpdate']);
            Route::delete('/{product}', [ProductController::class, 'apiDestroy']);
        });

        // Transactions API
        Route::prefix('transactions')->group(function () {
            Route::get('/', [TransactionController::class, 'apiIndex']);
            Route::post('/', [TransactionController::class, 'apiStore']);
            Route::get('/{transaction}', [TransactionController::class, 'apiShow']);
        });

        // Additional inventory endpoints
        Route::prefix('inventory')->group(function () {
            Route::get('/stock-levels', [ProductController::class, 'apiStockLevels']);
            Route::get('/activity-log', [TransactionController::class, 'apiActivityLog']);
            Route::post('/scan', [ProductController::class, 'apiProcessBarcode']);
        });
    });
});
