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
    <div class="bg-white rounded-lg shadow p-3 sm:p-4 mb-4 sm:mb-6">
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="safe">Stok Aman</option>
                    <option value="low">Stok Rendah</option>
                    <option value="out">Stok Habis</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                <input type="text" placeholder="Nama produk atau barcode..." class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex items-end">
                <button class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                    Filter
                </button>
            </div>
        </div>
    </div>    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Stok Aman</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $products->filter(function($p) { return ($p->current_stock ?? 0) > 10; })->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.318 15.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Stok Rendah</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $products->filter(function($p) { return ($p->current_stock ?? 0) > 0 && ($p->current_stock ?? 0) <= 10; })->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Stok Habis</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $products->filter(function($p) { return ($p->current_stock ?? 0) <= 0; })->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Total Produk</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $products->count() ?? 0 }}</p>
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
                            Status
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>                <tbody class="bg-white divide-y divide-gray-200">
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
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            @if(($product->current_stock ?? 0) > 10)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Stok Aman
                                </span>
                            @elseif(($product->current_stock ?? 0) > 0)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Stok Rendah
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Stok Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-indigo-600 hover:text-indigo-900 text-sm">
                                Update Stok
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
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
