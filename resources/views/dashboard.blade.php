@extends('layouts.admin')

@section('content')
<div>
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Dashboard Inventory</h1>
                    <p class="text-gray-600">Kelola stok produk Anda dengan mudah</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <div class="flex items-center space-x-2 text-sm text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Update terakhir: {{ date('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Stok dengan Cards yang Enhanced -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <!-- Total Produk -->
            <div class="group relative bg-white hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 shadow-lg hover:shadow-xl transition-all duration-300 rounded-2xl p-4 sm:p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Produk</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalProduk }}</p>
                        <div class="flex items-center mt-2">
                            <span class="text-xs {{ $persentasePerubahan >= 0 ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100' }} px-2 py-1 rounded-full">
                                {{ $persentasePerubahan >= 0 ? '+' : '' }}{{ $persentasePerubahan }}% dari bulan lalu
                            </span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-2xl group-hover:bg-blue-200 transition-colors duration-300">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tersedia -->
            <div class="group relative bg-white hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 shadow-lg hover:shadow-xl transition-all duration-300 rounded-2xl p-4 sm:p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Stok Tersedia</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stokTersedia }}</p>
                        <div class="flex items-center mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $persentaseStok }}%"></div>
                            </div>
                            <span class="text-xs text-gray-500 ml-2">{{ $persentaseStok }}%</span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 bg-green-100 rounded-2xl group-hover:bg-green-200 transition-colors duration-300">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Habis -->
            <div class="group relative bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-red-100 shadow-lg hover:shadow-xl transition-all duration-300 rounded-2xl p-4 sm:p-6 border border-gray-100 sm:col-span-2 md:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Stok Habis</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $stokHabis }}</p>
                        <div class="flex items-center mt-2">
                            @if($stokHabis > 0)
                                <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full">Perlu restock!</span>
                            @else
                                <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">Stok aman</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 bg-red-100 rounded-2xl group-hover:bg-red-200 transition-colors duration-300">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.318 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 mb-8">
            <!-- Aksi Cepat -->
            <div class="xl:col-span-1">
                <div class="bg-white shadow-lg rounded-2xl p-4 sm:p-6 border border-gray-100 h-full">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Aksi Cepat
                    </h2>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="/scan" class="group flex items-center justify-between w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"></path>
                                </svg>
                                <span class="font-semibold text-sm sm:text-base">Scan Barcode</span>
                            </div>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        <a href="/section/product" class="group flex items-center justify-between w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white px-4 sm:px-6 py-3 sm:py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <span class="font-semibold text-sm sm:text-base">Lihat Semua Produk</span>
                            </div>
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistik Pergerakan Stok -->
            <div class="md:col-span-1 xl:col-span-2">
                <div class="bg-white shadow-lg rounded-2xl p-4 sm:p-6 border border-gray-100 h-full">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Statistik Hari Ini
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="group bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl p-4 sm:p-6 transition-all duration-300 border border-blue-200">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-medium text-blue-800">Transaksi Masuk</h3>
                                <div class="p-1.5 sm:p-2 bg-blue-200 rounded-lg">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xl sm:text-2xl font-bold text-blue-900 mb-1">{{ $transaksiMasukHariIni }}</p>
                            <p class="text-xs text-blue-700">{{ $selisihMasuk >= 0 ? '+' : '' }}{{ $selisihMasuk }} dari kemarin</p>
                        </div>
                        <div class="group bg-gradient-to-br from-pink-50 to-pink-100 hover:from-pink-100 hover:to-pink-200 rounded-xl p-4 sm:p-6 transition-all duration-300 border border-pink-200">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-sm font-medium text-pink-800">Transaksi Keluar</h3>
                                <div class="p-1.5 sm:p-2 bg-pink-200 rounded-lg">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-xl sm:text-2xl font-bold text-pink-900 mb-1">{{ $transaksiKeluarHariIni }}</p>
                            <p class="text-xs text-pink-700">{{ $selisihKeluar >= 0 ? '+' : '' }}{{ $selisihKeluar }} dari kemarin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Terakhir -->
        <div class="bg-white shadow-lg rounded-2xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Transaksi Terakhir
                </h2>
            </div>
            
            <!-- Mobile view for transactions (visible on small screens) -->
            <div class="block lg:hidden">
                <div class="space-y-3 p-4">
                    @forelse($transaksiTerakhir as $transaksi)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-500">{{ $transaksi->product && $transaksi->product->date_received ? date('d M Y', strtotime($transaksi->product->date_received)) : '-' }}</span>
                            @if($transaksi->transaction_type == 'IN')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">IN</span>
                            @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">OUT</span>
                            @endif
                        </div>
                        <div class="text-sm font-medium text-gray-900">{{ $transaksi->product ? $transaksi->product->product_name : 'Produk tidak tersedia' }}</div>
                        <div class="text-xs text-gray-500 mb-2">Barcode: {{ $transaksi->barcode ?? '-' }}</div>
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-semibold text-gray-900">
                                {{ $transaksi->transaction_type == 'IN' ? '+' : '-' }}{{ $transaksi->quantity ?? 0 }}
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $transaksi->notes ?? 'Selesai' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">Belum ada transaksi</div>
                    @endforelse
                </div>
            </div>
            
            <!-- Desktop view (hidden on small screens) -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transaksiTerakhir as $transaksi)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaksi->product && $transaksi->product->date_received ? date('Y-m-d', strtotime($transaksi->product->date_received)) : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $transaksi->product ? $transaksi->product->product_name : 'Produk tidak tersedia' }}</div>
                                <div class="text-sm text-gray-500">{{ $transaksi->barcode ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($transaksi->transaction_type == 'IN')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                    IN
                                </span>
                                @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                    </svg>
                                    OUT
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $transaksi->transaction_type == 'IN' ? '+' : '-' }}{{ $transaksi->quantity ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $transaksi->notes ?? 'Selesai' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-sm text-gray-700">Menampilkan {{ $transaksiTerakhir->count() }} dari {{ $totalTransaksi }} transaksi</p>
                    <a href="{{ route('inventory.activity') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200 flex items-center justify-center">
                        <span>Lihat semua</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection