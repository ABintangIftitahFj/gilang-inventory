@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-3 sm:py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4 mb-4 sm:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Level Stok Produk</h1>
            <p class="text-sm text-gray-600 mt-1">Pantau tingkat stok produk Anda</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-sm font-medium transition-all duration-200">
                Export Laporan
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <form action="{{ route('inventory.stock') }}" method="GET" class="bg-white rounded-lg shadow p-3 sm:p-4 mb-4 sm:mb-6">
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk atau barcode..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                    Cari
                </button>
                @if(request()->has('search'))
                    <a href="{{ route('inventory.stock') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-6">
        <!-- Total Item -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Item</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $products->sum('current_stock') ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <!-- Total Jenis Produk -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Produk</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $products->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <!-- Transaksi Masuk -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Transaksi Masuk</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $totalTransaksiMasuk ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <!-- Transaksi Keluar -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Transaksi Keluar</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $totalTransaksiKeluar ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Levels Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Daftar Level Stok</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produk
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Barcode
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stok Saat Ini
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products ?? [] as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $product->product_name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $product->barcode ?? 'N/A' }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $product->current_stock ?? 0 }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-indigo-600 hover:text-indigo-900 text-sm">
                                Update Stok
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data produk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
