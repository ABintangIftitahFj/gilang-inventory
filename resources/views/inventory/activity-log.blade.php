@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Log Aktivitas Inventori</h1>
            <p class="mt-1 text-sm text-gray-600">Riwayat semua aktivitas inventori</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Log
            </button>
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Clear Old Logs
            </button>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
                <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Aktivitas</label>
                <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    <option value="">Semua Aktivitas</option>
                    <option value="IN">Barang Masuk</option>
                    <option value="OUT">Barang Keluar</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Barang Masuk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activities->where('transaction_type', 'IN')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-xl">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Barang Keluar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activities->where('transaction_type', 'OUT')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Qty</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activities->sum('quantity') ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Log</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activities->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile View for Activity Log -->
    <div class="block lg:hidden space-y-4" id="mobileActivityList">
        @forelse($activities ?? [] as $activity)
        <div class="activity-card bg-white rounded-xl shadow-md p-4 border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="font-bold text-lg text-gray-900">
                            {{ $activity->product ? $activity->product->product_name : ($activity->product_name ?? 'Produk tidak ditemukan') }}
                        </div>
                        <div class="text-sm font-medium text-gray-600 mt-1">
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $activity->barcode ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        @if($activity->transaction_type === 'IN')
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Masuk
                            </span>
                        @elseif($activity->transaction_type === 'OUT')
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                                </svg>
                                Keluar
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $activity->transaction_type ?? 'N/A' }}
                            </span>
                        @endif
                        <div class="text-xl font-bold">
                            @if($activity->transaction_type === 'OUT')
                                <span class="text-red-600">-{{ $activity->quantity ?? 0 }}</span>
                            @else
                                <span class="text-green-600">+{{ $activity->quantity ?? 0 }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mt-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500 font-medium">WAKTU</div>
                        <div class="text-sm font-semibold text-gray-900 mt-1">
                            {{ isset($activity->created_at) ? $activity->created_at->format('d/m/Y') : 'N/A' }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ isset($activity->created_at) ? $activity->created_at->format('H:i') : '' }}
                        </div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500 font-medium">PETUGAS</div>
                        <div class="text-sm font-semibold text-gray-900 mt-1">
                            {{ $activity->user_name ?? 'System' }}
                        </div>
                    </div>
                </div>
                
                @if($activity->notes)
                <div class="mt-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                    <div class="text-xs text-blue-600 font-medium mb-1">KETERANGAN</div>
                    <div class="text-sm text-blue-800">{{ $activity->notes }}</div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-md p-8 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Aktivitas</h3>
            <p class="text-gray-500">Belum ada aktivitas yang tercatat dalam sistem</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop View for Activity Log -->
    <div class="hidden lg:block bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Aktivitas</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waktu
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities ?? [] as $activity)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">
                                {{ isset($activity->created_at) ? $activity->created_at->format('d/m/Y') : 'N/A' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ isset($activity->created_at) ? $activity->created_at->format('H:i') : '' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($activity->transaction_type === 'IN')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Masuk
                                </span>
                            @elseif($activity->transaction_type === 'OUT')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                                    </svg>
                                    Keluar
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $activity->transaction_type ?? 'N/A' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $activity->product ? $activity->product->product_name : ($activity->product_name ?? 'Produk tidak ditemukan') }}
                            </div>
                            @if(isset($activity->barcode))
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $activity->barcode }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold">
                                @if($activity->transaction_type === 'OUT')
                                    <span class="text-red-600">-{{ $activity->quantity ?? 0 }}</span>
                                @else
                                    <span class="text-green-600">+{{ $activity->quantity ?? 0 }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $activity->user_name ?? 'System' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600">
                                {{ $activity->notes ?? 'Tidak ada keterangan' }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Aktivitas</h3>
                                <p class="text-gray-500">Belum ada aktivitas yang tercatat dalam sistem</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>        </table>
        </div>
    </div>
</div>

    <!-- Mobile View for Activity Log -->
    <div class="block lg:hidden space-y-4" id="mobileActivityList">
        @forelse($activities ?? [] as $activity)
        <div class="activity-card bg-white rounded-xl shadow-md p-4 border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="font-bold text-lg text-gray-900">
                            {{ $activity->product ? $activity->product->product_name : ($activity->product_name ?? 'Produk tidak ditemukan') }}
                        </div>
                        <div class="text-sm font-medium text-gray-600 mt-1">
                            <span class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $activity->barcode ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        @if($activity->transaction_type === 'IN')
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Masuk
                            </span>
                        @elseif($activity->transaction_type === 'OUT')
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                                </svg>
                                Keluar
                            </span>
                        @else
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $activity->transaction_type ?? 'N/A' }}
                            </span>
                        @endif
                        <div class="text-xl font-bold">
                            @if($activity->transaction_type === 'OUT')
                                <span class="text-red-600">-{{ $activity->quantity ?? 0 }}</span>
                            @else
                                <span class="text-green-600">+{{ $activity->quantity ?? 0 }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-3 mt-3">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500 font-medium">WAKTU</div>
                        <div class="text-sm font-semibold text-gray-900 mt-1">
                            {{ isset($activity->created_at) ? $activity->created_at->format('d/m/Y') : 'N/A' }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ isset($activity->created_at) ? $activity->created_at->format('H:i') : '' }}
                        </div>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="text-xs text-gray-500 font-medium">PETUGAS</div>
                        <div class="text-sm font-semibold text-gray-900 mt-1">
                            {{ $activity->user_name ?? 'System' }}
                        </div>
                    </div>
                </div>
                
                @if($activity->notes)
                <div class="mt-3 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                    <div class="text-xs text-blue-600 font-medium mb-1">KETERANGAN</div>
                    <div class="text-sm text-blue-800">{{ $activity->notes }}</div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-md p-8 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Aktivitas</h3>
            <p class="text-gray-500">Belum ada aktivitas yang tercatat dalam sistem</p>
        </div>
        @endforelse
    </div>

    <!-- Desktop View for Activity Log -->
    <div class="hidden lg:block bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Aktivitas</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waktu
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities ?? [] as $activity)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">
                                {{ isset($activity->created_at) ? $activity->created_at->format('d/m/Y') : 'N/A' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ isset($activity->created_at) ? $activity->created_at->format('H:i') : '' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($activity->transaction_type === 'IN')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Masuk
                                </span>
                            @elseif($activity->transaction_type === 'OUT')
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                                    </svg>
                                    Keluar
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $activity->transaction_type ?? 'N/A' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $activity->product ? $activity->product->product_name : ($activity->product_name ?? 'Produk tidak ditemukan') }}
                            </div>
                            @if(isset($activity->barcode))
                                <div class="text-xs text-gray-500 mt-1">
                                    <span class="bg-gray-100 px-2 py-1 rounded">{{ $activity->barcode }}</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold">
                                @if($activity->transaction_type === 'OUT')
                                    <span class="text-red-600">-{{ $activity->quantity ?? 0 }}</span>
                                @else
                                    <span class="text-green-600">+{{ $activity->quantity ?? 0 }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $activity->user_name ?? 'System' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600">
                                {{ $activity->notes ?? 'Tidak ada keterangan' }}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Aktivitas</h3>
                                <p class="text-gray-500">Belum ada aktivitas yang tercatat dalam sistem</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
