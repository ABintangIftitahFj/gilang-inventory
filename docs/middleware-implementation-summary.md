# Panduan Implementasi Middleware dan API Gilang Inventory

## I. Pendahuluan

Dokumen ini memberikan ringkasan komprehensif tentang middleware dan API yang diimplementasikan dalam sistem Gilang Inventory, termasuk perubahan pendekatan yang dilakukan untuk mengatasi masalah yang muncul selama pengembangan.

## II. Implementasi Middleware

### A. Middleware yang Diimplementasikan

| Middleware                | Fungsi                                           | File                                                |
| ------------------------- | ------------------------------------------------ | --------------------------------------------------- |
| AdminAccess               | Membatasi akses ke fitur admin berdasarkan email | `app/Http/Middleware/AdminAccess.php`               |
| InventoryAccess           | Membatasi akses ke fitur inventaris              | `app/Http/Middleware/InventoryAccess.php`           |
| ApiRateLimiter            | Membatasi jumlah permintaan API                  | `app/Http/Middleware/ApiRateLimiter.php`            |
| ValidateApiAuthentication | Memvalidasi token API                            | `app/Http/Middleware/ValidateApiAuthentication.php` |
| ValidateInventoryData     | Memvalidasi data inventaris                      | `app/Http/Middleware/ValidateInventoryData.php`     |

### B. Pendaftaran Middleware

Semua middleware terdaftar dalam `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    'web' => [
        // Standard Laravel web middleware
    ],
    'api' => [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];

protected $routeMiddleware = [
    // Standard Laravel middleware
    'inventory.access' => \App\Http\Middleware\InventoryAccess::class,
    'admin.access' => \App\Http\Middleware\AdminAccess::class,
    'api.rate.limit' => \App\Http\Middleware\ApiRateLimiter::class,
    'api.auth' => \App\Http\Middleware\ValidateApiAuthentication::class,
    'inventory.data' => \App\Http\Middleware\ValidateInventoryData::class,
];
```

### C. Alur Kerja Middleware

1. **AdminAccess**

    - Memeriksa apakah pengguna terotentikasi
    - Memeriksa apakah flag is_admin bernilai true, atau jika belum ada kolom is_admin, cek apakah email mengandung kata 'admin'
    - Menolak akses dengan pesan yang sesuai jika tidak memenuhi syarat

2. **InventoryAccess**

    - Memverifikasi otentikasi pengguna
    - Memeriksa apakah pengguna memiliki izin untuk mengakses fitur inventaris
    - Mengarahkan ke dashboard jika tidak memiliki akses

3. **ApiRateLimiter**
    - Membatasi jumlah permintaan API per IP atau token
    - Merespons dengan status 429 jika melebihi batas

## III. Implementasi API

### A. Struktur Route API

```php
// Base API test route
Route::get('test', function () {
    return response()->json(['message' => 'API is working!']);
});

// API v1 routes
Route::prefix('v1')->group(function () {
    // Public routes - no auth required
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);

    // Protected routes - Sanctum auth required
    Route::middleware('auth:sanctum')->group(function () {
        // Auth management
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/user', [AuthController::class, 'user']);

        // Products API
        Route::prefix('products')->group(function () {
            // Product CRUD operations
        });

        // Transactions API
        Route::prefix('transactions')->group(function () {
            // Transaction management
        });

        // Additional inventory endpoints
        Route::prefix('inventory')->group(function () {
            // Inventory-specific operations
        });
    });
});
```

### B. Autentikasi API dengan Sanctum

1. **Instalasi Sanctum**

    - `composer require laravel/sanctum`
    - Publikasi dan migrasi

2. **Modifikasi Model User**

    - Penambahan trait `HasApiTokens`

3. **Autentikasi via Controller**
    - Login dengan email/password
    - Pembuatan token API
    - Validasi token untuk permintaan terlindungi

## IV. Perubahan Pendekatan dan Solusi

### A. Masalah API Routes yang Tidak Terdaftar

#### Masalah yang Dihadapi:

-   Route API tidak terdaftar dengan benar
-   Endpoint API tidak dapat diakses
-   Middleware tidak berfungsi dengan benar

#### Pendekatan Awal:

-   Menggunakan konfigurasi default Laravel
-   Menyelipkan route API ke dalam file web.php

#### Solusi yang Diimplementasikan:

1. **Reorganisasi Route**

    - Pemisahan route API dan web dengan lebih jelas
    - Penerapan versioning untuk API (`/api/v1/...`)

2. **Perbaikan RouteServiceProvider**

    - Pendefinisian namespace yang tepat untuk controller API
    - Pengaturan prefix yang konsisten

3. **Konfigurasi Middleware yang Tepat**
    - Pendaftaran semua middleware di Kernel.php
    - Penerapan middleware dalam grup yang tepat

### B. Masalah Otentikasi API

#### Masalah yang Dihadapi:

-   Token API tidak divalidasi dengan benar
-   Kesulitan dalam memahami alur otentikasi API

#### Solusi yang Diimplementasikan:

1. **Menggunakan Laravel Sanctum**

    - Sistem otentikasi token API yang lebih andal
    - Dukungan untuk kemampuan token (token abilities)

2. **ValidateApiAuthentication Middleware**
    - Validasi tambahan untuk token API
    - Penambahan informasi pengguna ke header permintaan

## V. Petunjuk Penggunaan

### A. Membuat Admin Utama

Untuk membuat admin utama, gunakan Laravel Tinker:

```bash
# Di terminal PowerShell (Windows)
cd d:/laragon/www/gilang-inventory
php artisan tinker
```

```php
// Di dalam Tinker
$admin = new \App\Models\User();
$admin->name = 'Administrator';
$admin->email = 'admin@example.com';  # Email bisa apa saja
$admin->password = bcrypt('password123');
$admin->is_admin = true;  # Set flag is_admin ke true
$admin->save();
```

### B. Menggunakan API

1. **Login dan Mendapatkan Token**

```bash
curl -X POST http://localhost/gilang-inventory/public/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@inventory.com","password":"password123"}'
```

2. **Menggunakan Token untuk Mengakses Endpoint Terlindungi**

```bash
curl -X GET http://localhost/gilang-inventory/public/api/v1/products \
  -H "Authorization: Bearer {your_token}"
```

## VI. Kesimpulan

Implementasi middleware dan API dalam Gilang Inventory menyediakan struktur yang aman dan terorganisir untuk manajemen inventaris. Perubahan pendekatan yang dilakukan selama pengembangan telah menghasilkan sistem yang lebih andal dan mudah dikelola.

Dengan kombinasi middleware yang tepat dan API yang terstruktur, sistem ini menawarkan:

1. **Keamanan** yang berlapis untuk melindungi data sensitif
2. **Skalabilitas** untuk pertumbuhan aplikasi di masa depan
3. **Fleksibilitas** untuk integrasi dengan sistem lain
4. **Kemudahan penggunaan** untuk pengguna akhir dan developer
