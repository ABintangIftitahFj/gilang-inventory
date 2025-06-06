# Dokumentasi Middleware dan API - Gilang Inventory

## Pendahuluan

Dokumen ini menjelaskan tentang middleware, API, dan pendekatan yang digunakan dalam sistem Gilang Inventory. Ini mencakup penjelasan tentang fungsi masing-masing middleware, struktur API, proses autentikasi, dan penggunaan middleware untuk keamanan serta validasi data.

## Middleware yang Dibuat

### 1. InventoryAccess Middleware

**File:** `app/Http/Middleware/InventoryAccess.php`

**Fungsi:** Membatasi akses ke fitur manajemen inventaris hanya untuk pengguna yang memiliki hak akses inventaris.

**Implementasi:**
- Memeriksa apakah pengguna saat ini memiliki hak akses inventaris
- Jika tidak memiliki hak akses, pengguna akan dialihkan ke halaman dashboard dengan pesan error
- Penentuan hak akses inventaris berdasarkan role pengguna yang tersimpan dalam tabel users

**Bagaimana cara menggunakannya:**
```php
Route::middleware(['inventory.access'])->prefix('inventory')->group(function () {
    // Product routes
    Route::resource('products', ProductController::class);
    
    // Transaction routes
    Route::resource('transactions', TransactionController::class);
});
```

### 2. AdminAccess Middleware

**File:** `app/Http/Middleware/AdminAccess.php`

**Fungsi:** Memastikan hanya admin yang dapat mengakses halaman-halaman administratif.

**Implementasi:**
- Memeriksa apakah email pengguna mengandung string "admin" atau pengguna memiliki role admin
- Jika bukan admin, pengguna akan dialihkan kembali dengan pesan error
- Admin memiliki akses ke semua fitur termasuk manajemen pengguna, pengaturan sistem, dan log aktivitas

**Bagaimana cara menggunakannya:**
```php
Route::middleware(['admin.access'])->prefix('admin')->group(function () {
    // User management
    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');
});
```

### 3. ApiRateLimiter Middleware

**File:** `app/Http/Middleware/ApiRateLimiter.php`

**Fungsi:** Membatasi jumlah permintaan API dalam periode waktu tertentu untuk mencegah penyalahgunaan API.

**Implementasi:**
- Menggunakan fitur rate limiting dari Laravel
- Membatasi permintaan API ke 60 permintaan per menit per IP address
- Jika melebihi batas, akan mengembalikan respons dengan status 429 (Too Many Requests)

**Bagaimana cara menggunakannya:**
```php
Route::middleware(['api.rate.limiter'])->group(function () {
    // API routes
});
```

### 4. ValidateApiAuthentication Middleware

**File:** `app/Http/Middleware/ValidateApiAuthentication.php`

**Fungsi:** Memvalidasi token API untuk permintaan API.

**Implementasi:**
- Menggunakan Laravel Sanctum untuk validasi token API
- Memeriksa apakah token API valid dan tidak kadaluwarsa
- Jika token tidak valid, mengembalikan respons dengan status 401 (Unauthorized)

**Bagaimana cara menggunakannya:**
```php
Route::middleware(['auth:sanctum'])->group(function () {
    // Protected API endpoints
});
```

### 5. ValidateInventoryData Middleware

**File:** `app/Http/Middleware/ValidateInventoryData.php`

**Fungsi:** Memvalidasi format dan integritas data inventaris yang dikirim dalam permintaan.

**Implementasi:**
- Memeriksa apakah data yang dikirim sesuai dengan format yang diharapkan
- Memvalidasi data inventaris seperti SKU, harga, dan kuantitas
- Jika validasi gagal, permintaan akan ditolak dengan pesan error yang sesuai

**Bagaimana cara menggunakannya:**
```php
Route::middleware(['validate.inventory'])->group(function () {
    // Routes that require inventory data validation
});
```

## Struktur API

### Endpoint API

API Gilang Inventory menggunakan prefix '/api/v1' untuk semua endpoint API. Berikut adalah endpoint utama:

1. **Autentikasi API**
   - `POST /api/v1/login` - Login dan mendapatkan token API
   - `POST /api/v1/register` - Registrasi pengguna baru
   - `POST /api/v1/logout` - Logout dan mencabut token API

2. **Manajemen Produk**
   - `GET /api/v1/products` - Mendapatkan daftar produk
   - `POST /api/v1/products` - Menambahkan produk baru
   - `GET /api/v1/products/{id}` - Mendapatkan detail produk
   - `PUT /api/v1/products/{id}` - Memperbarui produk
   - `DELETE /api/v1/products/{id}` - Menghapus produk

3. **Manajemen Transaksi**
   - `GET /api/v1/transactions` - Mendapatkan daftar transaksi
   - `POST /api/v1/transactions` - Membuat transaksi baru
   - `GET /api/v1/transactions/{id}` - Mendapatkan detail transaksi
   - `PUT /api/v1/transactions/{id}` - Memperbarui transaksi
   - `DELETE /api/v1/transactions/{id}` - Membatalkan transaksi

### File yang Diperlukan untuk API

1. **Controllers:**
   - `app/Http/Controllers/Api/AuthController.php` - Controller untuk autentikasi API
   - `app/Http/Controllers/Api/ProductController.php` - Controller untuk API produk
   - `app/Http/Controllers/Api/TransactionController.php` - Controller untuk API transaksi

2. **Routes:**
   - `routes/api.php` - Definisi route API

3. **Middleware:**
   - `app/Http/Middleware/ValidateApiAuthentication.php`
   - `app/Http/Middleware/ApiRateLimiter.php`

4. **Service Providers:**
   - `app/Providers/RouteServiceProvider.php` - Konfigurasi untuk perutean API

## Implementasi Autentikasi API dengan Sanctum

### 1. Instalasi Laravel Sanctum

Laravel Sanctum diinstal dengan perintah:
```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 2. Konfigurasi Model User

Model `User` sudah dimodifikasi untuk menggunakan trait `HasApiTokens` dari Laravel Sanctum:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // ...
}
```

### 3. Konfigurasi Middleware

Middleware Sanctum ditambahkan ke grup middleware API di `app/Http/Kernel.php`:

```php
protected $middlewareGroups = [
    // ...
    'api' => [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];
```

### 4. Implementasi Autentikasi API

Autentikasi API dilakukan di `app/Http/Controllers/Api/AuthController.php`:

```php
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Invalid login credentials'
        ], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    $token = $user->createToken('auth-token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}
```

## Permasalahan dan Solusi

### Permasalahan API yang Tidak Muncul

Awalnya, API tidak terdaftar dan tidak dapat diakses. Setelah investigasi, ditemukan beberapa masalah:

1. **Masalah Route Provider:**
   - Route API tidak dimuat dengan benar di `RouteServiceProvider`
   - Laravel tidak memetakan endpoint API dengan benar

2. **Masalah Namespace:**
   - Controller API berada dalam namespace yang berbeda tetapi tidak didefinisikan dengan benar

3. **Masalah Middleware:**
   - Middleware API tidak terdaftar dalam `Kernel.php`

### Pendekatan dan Solusi

1. **Perbaikan RouteServiceProvider:**
   ```php
   public function boot()
   {
       $this->routes(function () {
           Route::middleware('api')
               ->prefix('api/v1')
               ->namespace($this->namespace.'\\Api')
               ->group(base_path('routes/api.php'));

           Route::middleware('web')
               ->namespace($this->namespace)
               ->group(base_path('routes/web.php'));
       });
   }
   ```

2. **Pendaftaran Middleware:**
   Semua middleware didaftarkan dengan benar di `app/Http/Kernel.php`:
   ```php
   protected $routeMiddleware = [
       // ...
       'inventory.access' => \App\Http\Middleware\InventoryAccess::class,
       'admin.access' => \App\Http\Middleware\AdminAccess::class,
       'api.rate.limiter' => \App\Http\Middleware\ApiRateLimiter::class,
       'validate.api.auth' => \App\Http\Middleware\ValidateApiAuthentication::class,
       'validate.inventory' => \App\Http\Middleware\ValidateInventoryData::class,
   ];
   ```

3. **Pemisahan Controller:**
   Controller API dipisahkan dari controller web:
   ```
   app/
     Http/
       Controllers/
         Api/
           AuthController.php
           ProductController.php
           TransactionController.php
         AuthController.php
         ProductController.php
         TransactionController.php
   ```

4. **Perbaikan Route API:**
   File `routes/api.php` diperbaiki untuk menggunakan namespace yang benar:
   ```php
   Route::post('/login', 'AuthController@login');
   Route::post('/register', 'AuthController@register');

   Route::middleware('auth:sanctum')->group(function () {
       Route::apiResource('products', 'ProductController');
       Route::apiResource('transactions', 'TransactionController');
       Route::post('/logout', 'AuthController@logout');
   });
   ```

## Pengujian API

### Cara Melakukan Pengujian

1. **Login dan Mendapatkan Token:**
   ```bash
   curl -X POST http://localhost/gilang-inventory/public/api/v1/login \
     -H 'Content-Type: application/json' \
     -d '{"email":"admin@example.com","password":"password123"}'
   ```

2. **Menggunakan Token untuk Permintaan API:**
   ```bash
   curl -X GET http://localhost/gilang-inventory/public/api/v1/products \
     -H 'Authorization: Bearer {token}'
   ```

3. **Membuat Product Baru:**
   ```bash
   curl -X POST http://localhost/gilang-inventory/public/api/v1/products \
     -H 'Authorization: Bearer {token}' \
     -H 'Content-Type: application/json' \
     -d '{"name":"Product A","sku":"P001","description":"Description","price":100,"stock":10}'
   ```

## Kesimpulan

Implementasi middleware dan API dalam Gilang Inventory memungkinkan:

1. **Keamanan** - Melindungi sumber daya dengan autentikasi dan otorisasi
2. **Rate Limiting** - Mencegah penyalahgunaan API
3. **Validasi Data** - Memastikan integritas data
4. **Akses Terstruktur** - Membatasi akses berdasarkan peran pengguna

Dengan pendekatan yang diperbaiki, sistem sekarang memiliki struktur yang lebih terorganisir dan modular, memungkinkan pengelolaan inventaris yang efisien melalui web interface dan API.
