<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BarcodeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda mendaftarkan rute API untuk aplikasi Anda.
|
*/

// Rute untuk mengecek status API
Route::get('test', fn () => response()->json(['message' => 'API is working!']));

// --- API Versi 1 ---
Route::prefix('v1')->group(function () {
    
    // --- Rute Publik (Tidak perlu login) ---
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    
    // Endpoint utama untuk check barcode
    Route::post('barcode/check', [BarcodeController::class, 'checkBarcode']);


    // --- Rute Terproteksi (Wajib login/autentikasi via Sanctum) ---
    Route::middleware('auth:sanctum')->group(function () {
        
        // Rute terkait Autentikasi User
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/user', [AuthController::class, 'user']);

        // Rute untuk Resource Products (CRUD)
        Route::apiResource('products', ProductController::class);

        // Rute untuk Resource Transactions
        Route::prefix('transactions')->group(function() {
            Route::get('/', [TransactionController::class, 'index']);
            Route::post('/', [TransactionController::class, 'store']);
            Route::get('/{transaction}', [TransactionController::class, 'show']);
        });

        // Rute tambahan terkait Inventory
        Route::prefix('inventory')->group(function () {
            Route::get('stock-levels', [ProductController::class, 'stockLevels']);
            Route::get('activity-log', [TransactionController::class, 'activityLog']);
            
            // Anda punya 'processBarcode' di sini, mungkin maksudnya berbeda dengan 'checkBarcode'?
            // Jika fungsinya sama, pertimbangkan untuk menyatukannya.
            Route::post('scan', [ProductController::class, 'processBarcode']);
        });
    });
});


// --- Rute Legacy (jika masih dibutuhkan untuk kompatibilitas) ---
// Tempatkan di luar group v1 jika endpoint ini tidak mengikuti standar versi
Route::post('check-barcode', [BarcodeController::class, 'checkBarcode']);