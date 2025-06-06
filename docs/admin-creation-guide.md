# Panduan Membuat Admin Utama dengan Tinker

Dokumen ini menjelaskan cara membuat akun admin utama menggunakan Laravel Tinker untuk Gilang Inventory System.

## Prasyarat

Sebelum membuat admin utama, pastikan:

1. Laravel telah terinstal dengan benar
2. Database telah dikonfigurasi dengan benar di file `.env`
3. Migrasi database telah dijalankan dengan `php artisan migrate`

## Cara Membuat Admin Utama

### Langkah 1: Buka Laravel Tinker

Buka terminal atau command prompt, lalu jalankan:

```bash
cd path/to/gilang-inventory
php artisan tinker
```

### Langkah 2: Buat Pengguna Admin

Salin dan tempel kode berikut ke dalam Tinker:

```php
// Method 1: Menggunakan create()
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

User::create([
    'name' => 'Administrator',
    'email' => 'admin@example.com',  // Email bisa apa saja
    'email_verified_at' => now(),
    'password' => Hash::make('admin123456'),
    'is_admin' => true,  // Set flag is_admin ke true
    'remember_token' => Str::random(10),
]);

// Method 2: Menggunakan instansiasi (alternatif)
$admin = new \App\Models\User();
$admin->name = 'Administrator';
$admin->email = 'admin@example.com';  // Email bisa apa saja
$admin->password = bcrypt('admin123456');
$admin->is_admin = true;  // Set flag is_admin ke true
$admin->email_verified_at = now();
$admin->save();
```

> **CATATAN**: Dengan implementasi terbaru, email admin bisa menggunakan format apa saja asalkan kolom `is_admin` diset ke `true`. Jika database belum diupdate dengan kolom `is_admin`, sistem akan tetap memeriksa apakah email mengandung kata "admin".

### Langkah 3: Verifikasi Pembuatan Admin

Untuk memastikan admin telah berhasil dibuat, jalankan:

```php
User::where('email', 'admin@gilang-inventory.com')->first();
```

Jika berhasil, Tinker akan menampilkan detail pengguna admin yang baru dibuat.

### Langkah 4: Keluar dari Tinker

Ketik `exit` atau tekan `Ctrl+C` untuk keluar dari Tinker.

## Akses Admin

Dengan akun admin yang dibuat, Anda dapat:

1. Login menggunakan kredensial:

    - Email: admin@gilang-inventory.com
    - Password: admin123456

2. Akses semua fitur administrator:

    - Manajemen pengguna: `/admin/users`
    - Pengaturan sistem: `/admin/settings`
    - Log aktivitas: `/admin/logs`

3. Akses semua fitur inventaris:
    - Manajemen produk: `/inventory/products`
    - Manajemen transaksi: `/inventory/transactions`
    - Laporan stok: `/inventory/stock-levels`
    - Log aktivitas: `/inventory/activity-log`

## Keamanan

Catatan penting tentang keamanan:

1. Segera ubah password admin default setelah login pertama
2. Pastikan flag `is_admin` diatur ke `true` untuk akun administrator
3. Pastikan akun admin ini hanya digunakan oleh personel yang berwenang
4. Jika database belum dimigrasi dengan kolom `is_admin`, email masih harus mengandung kata "admin"
5. Untuk implementasi yang lebih aman di masa depan, pertimbangkan untuk menggunakan tabel role dan permission terpisah

## Pemecahan Masalah

Jika terjadi masalah saat membuat admin, periksa:

1. Koneksi database
2. Struktur tabel users
3. Middleware AdminAccess untuk memastikan akses administrator berfungsi dengan benar

Untuk masalah lainnya, lihat file log Laravel di `storage/logs/laravel.log`.
