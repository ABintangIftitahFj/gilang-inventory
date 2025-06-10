@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengaturan Sistem</h1>
            <p class="mt-1 text-sm text-gray-600">Konfigurasi sistem inventory</p>
        </div>
        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow font-semibold transition-all duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Simpan Perubahan
        </button>
    </div>

    <!-- Mobile Tabs -->
    <div class="block lg:hidden mb-6">
        <div class="bg-white rounded-xl shadow-md p-1">
            <div class="grid grid-cols-2 gap-1">
                <button class="settings-tab-btn active bg-indigo-100 text-indigo-700 py-3 px-4 rounded-lg font-medium text-sm transition-all" data-tab="general">
                    Umum
                </button>
                <button class="settings-tab-btn text-gray-600 py-3 px-4 rounded-lg font-medium text-sm transition-all" data-tab="notifications">
                    Notifikasi
                </button>
            </div>
            <div class="grid grid-cols-2 gap-1 mt-1">
                <button class="settings-tab-btn text-gray-600 py-3 px-4 rounded-lg font-medium text-sm transition-all" data-tab="security">
                    Keamanan
                </button>
                <button class="settings-tab-btn text-gray-600 py-3 px-4 rounded-lg font-medium text-sm transition-all" data-tab="backup">
                    Cadangan
                </button>
            </div>
        </div>
    </div>

    <!-- Desktop Tabs -->
    <div class="hidden lg:block bg-white rounded-xl shadow-md mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button class="settings-tab-btn active border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="general">
                    Umum
                </button>
                <button class="settings-tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="notifications">
                    Notifikasi
                </button>
                <button class="settings-tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="security">
                    Keamanan
                </button>
                <button class="settings-tab-btn border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="backup">
                    Cadangan & Pemulihan
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="space-y-6">
        <!-- General Settings Tab -->
        <div id="general-tab" class="tab-content">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Detail Perusahaan</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Informasi ini akan ditampilkan pada laporan dan dokumen yang dicetak.
                    </p>
                </div>

                <form class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Perusahaan
                            </label>
                            <input type="text" name="company_name" id="company_name" value="Gilang Inventory" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>

                        <div>
                            <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" name="company_phone" id="company_phone" value="+62 812 3456 7890" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="company_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Perusahaan
                        </label>
                        <textarea name="company_address" id="company_address" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">Jl. Contoh No. 123, Jakarta, Indonesia</textarea>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="default_currency" class="block text-sm font-medium text-gray-700 mb-2">
                                Mata Uang Default
                            </label>
                            <select name="default_currency" id="default_currency" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                <option value="IDR">Rupiah (IDR)</option>
                                <option value="USD">US Dollar (USD)</option>
                            </select>
                        </div>

                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">
                                Zona Waktu
                            </label>
                            <select name="timezone" id="timezone" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                <option value="Asia/Jakarta">Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar">Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura">Asia/Jayapura (WIT)</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifications Tab -->
        <div id="notifications-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Pengaturan Notifikasi</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Atur bagaimana dan kapan Anda ingin menerima notifikasi.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Notifikasi Stok Rendah</h4>
                            <p class="text-sm text-gray-600">Terima notifikasi ketika stok produk hampir habis</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Email Laporan Harian</h4>
                            <p class="text-sm text-gray-600">Terima ringkasan aktivitas harian melalui email</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Notifikasi Push</h4>
                            <p class="text-sm text-gray-600">Terima notifikasi push di browser</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tab -->
        <div id="security-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Pengaturan Keamanan</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Kelola pengaturan keamanan sistem.
                    </p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="session_timeout" class="block text-sm font-medium text-gray-700 mb-2">
                            Timeout Sesi (menit)
                        </label>
                        <input type="number" name="session_timeout" id="session_timeout" value="120" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Autentikasi Dua Faktor</h4>
                            <p class="text-sm text-gray-600">Tambahkan lapisan keamanan ekstra</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <h4 class="font-medium text-gray-900">Log Aktivitas Pengguna</h4>
                            <p class="text-sm text-gray-600">Catat semua aktivitas pengguna</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backup Tab -->
        <div id="backup-tab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Cadangan & Pemulihan</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Kelola cadangan data sistem.
                    </p>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <button class="p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-500 transition-colors">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                            <h4 class="font-medium text-gray-900 mb-2">Buat Cadangan</h4>
                            <p class="text-sm text-gray-600">Buat cadangan data sistem sekarang</p>
                        </button>

                        <button class="p-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-indigo-500 transition-colors">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <h4 class="font-medium text-gray-900 mb-2">Pulihkan Data</h4>
                            <p class="text-sm text-gray-600">Pulihkan data dari file cadangan</p>
                        </button>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-900 mb-4">Cadangan Otomatis</h4>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h5 class="font-medium text-gray-900">Cadangan Harian</h5>
                                    <p class="text-sm text-gray-600">Buat cadangan setiap hari pada pukul 02:00</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                                <div>
                                    <h5 class="font-medium text-gray-900">Cadangan Mingguan</h5>
                                    <p class="text-sm text-gray-600">Buat cadangan setiap Minggu</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.settings-tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');
            
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-indigo-100', 'text-indigo-700', 'border-indigo-500', 'text-indigo-600');
                btn.classList.add('text-gray-600', 'border-transparent');
            });
            
            // Add active class to clicked button
            button.classList.add('active');
            if (window.innerWidth < 1024) { // Mobile
                button.classList.add('bg-indigo-100', 'text-indigo-700');
                button.classList.remove('text-gray-600');
            } else { // Desktop
                button.classList.add('border-indigo-500', 'text-indigo-600');
                button.classList.remove('text-gray-600', 'border-transparent');
            }
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show target tab content
            const targetContent = document.getElementById(targetTab + '-tab');
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    });
});
</script>
@endsection
