@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center mb-4">
                <a href="{{ route('dashboard') }}" class="mr-4 p-2 rounded-lg hover:bg-white/50 transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Scanner Barcode</h1>
                    <p class="text-gray-600">Scan barcode produk untuk kelola inventory</p>
                </div>
            </div>
        </div>

        <!-- Scanner Area -->
        <div class="max-w-md mx-auto mb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <!-- Scanner Status -->
                <div class="p-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-semibold">Scan Berhasil!</span>
                    </div>
                </div>

                <!-- Scanner Preview Area -->
                <div class="relative bg-gray-900 aspect-square flex items-center justify-center">
                    <div class="absolute inset-4 border-2 border-white rounded-lg opacity-50"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-green-500/20 to-transparent animate-pulse"></div>
                    
                    <!-- Scanner Line Animation -->
                    <div class="absolute left-4 right-4 h-0.5 bg-green-400 animate-bounce" style="top: 45%;"></div>
                    
                    <!-- Barcode Visualization -->
                    <div class="z-10 bg-white p-4 rounded-lg shadow-lg">
                        <div class="flex space-x-1">
                            <div class="w-1 h-12 bg-black"></div>
                            <div class="w-0.5 h-12 bg-black"></div>
                            <div class="w-1.5 h-12 bg-black"></div>
                            <div class="w-0.5 h-12 bg-black"></div>
                            <div class="w-1 h-12 bg-black"></div>
                            <div class="w-2 h-12 bg-black"></div>
                            <div class="w-0.5 h-12 bg-black"></div>
                            <div class="w-1 h-12 bg-black"></div>
                            <div class="w-1.5 h-12 bg-black"></div>
                            <div class="w-0.5 h-12 bg-black"></div>
                        </div>
                        <p class="text-xs text-center mt-2 font-mono">8901234567890</p>
                    </div>
                </div>

                <!-- Scan Result -->
                <div class="p-4 bg-gray-50">
                    <p class="text-sm text-gray-600 text-center">
                        <span class="font-semibold text-green-600">Barcode:</span> 8901234567890
                    </p>
                </div>
            </div>
        </div>

        <!-- Product Found - Main Content -->
        <div class="max-w-4xl mx-auto">
            <!-- Product Information Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 mb-6 overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-blue-100 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Produk Ditemukan</h2>
                            <p class="text-gray-600">Informasi produk dari database</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Nama Produk</span>
                                <span class="text-sm font-bold text-gray-900 text-right">Pulpen Gel Hitam</span>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Barcode</span>
                                <span class="text-sm font-mono text-gray-900">8901234567890</span>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Supplier</span>
                                <span class="text-sm text-gray-900">PT. Stationary Indo</span>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Grade</span>
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">A</span>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Lokasi</span>
                                <span class="text-sm text-gray-900">Rak A-1-2</span>
                            </div>
                        </div>

                        <!-- Physical Properties -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Dimensi (P×L×T)</span>
                                <span class="text-sm text-gray-900">15 × 1.2 × 1.2 cm</span>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Berat</span>
                                <span class="text-sm text-gray-900">12 gram</span>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Tanggal Terima</span>
                                <span class="text-sm text-gray-900">2025-05-15</span>
                            </div>
                            <div class="flex justify-between items-start border-b border-gray-100 pb-3">
                                <span class="text-sm font-medium text-gray-500">Status</span>
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Active</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-gray-500">Stok Saat Ini</span>
                                <span class="text-lg font-bold text-indigo-600">245 pcs</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Catatan:</h4>
                        <p class="text-sm text-gray-600">Pulpen gel dengan tinta berkualitas tinggi, cocok untuk penggunaan sehari-hari. Stok dalam kondisi baik.</p>
                    </div>
                </div>
            </div>

            <!-- Action Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- IN Transaction -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden group hover:shadow-2xl transition-all duration-300">
                    <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 border-b border-green-100">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors duration-300">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Transaksi Masuk</h3>
                                <p class="text-sm text-gray-600">Tambah stok produk</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Gunakan untuk menambahkan stok produk yang baru datang atau hasil return.</p>
                        <button class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Pilih Transaksi IN</span>
                        </button>
                    </div>
                </div>

                <!-- OUT Transaction -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden group hover:shadow-2xl transition-all duration-300">
                    <div class="p-6 bg-gradient-to-br from-red-50 to-pink-50 border-b border-red-100">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-red-100 rounded-xl group-hover:bg-red-200 transition-colors duration-300">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Transaksi Keluar</h3>
                                <p class="text-sm text-gray-600">Kurangi stok produk</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Gunakan untuk mencatat pengeluaran stok karena penjualan atau penggunaan internal.</p>
                        <button class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                            </svg>
                            <span>Pilih Transaksi OUT</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <button class="flex items-center justify-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Scan Ulang</span>
                </button>
                <button class="flex items-center justify-center space-x-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-3 px-6 rounded-xl transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>Lihat Detail</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification (Hidden by default) -->
<div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span>Scan berhasil!</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show toast notification
    setTimeout(() => {
        const toast = document.getElementById('toast');
        toast.classList.remove('translate-x-full');
        
        // Hide toast after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
        }, 3000);
    }, 500);

    // Button click handlers (you can replace with actual form submissions)
    document.querySelector('.bg-gradient-to-r.from-green-500').addEventListener('click', function() {
        // Redirect to IN transaction form
        console.log('Redirecting to IN transaction form...');
        // window.location.href = '/transaction/in/8901234567890';
    });

    document.querySelector('.bg-gradient-to-r.from-red-500').addEventListener('click', function() {
        // Redirect to OUT transaction form
        console.log('Redirecting to OUT transaction form...');
        // window.location.href = '/transaction/out/8901234567890';
    });
});
</script>
@endsection