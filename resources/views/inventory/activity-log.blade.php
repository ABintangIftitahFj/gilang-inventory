@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-3 sm:py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4 mb-4 sm:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Log Aktivitas Inventori</h1>
            <p class="text-sm text-gray-600 mt-1">Riwayat semua aktivitas inventori</p>
        </div>
    </div>

    <!-- Filter Section -->
    <form action="{{ route('inventory.activity') }}" method="GET" class="bg-white rounded-lg shadow p-3 sm:p-4 mb-4 sm:mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Aktivitas</label>
                <select name="transaction_type" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Aktivitas</option>
                    <option value="IN" {{ request('transaction_type') == 'IN' ? 'selected' : '' }}>Barang Masuk</option>
                    <option value="OUT" {{ request('transaction_type') == 'OUT' ? 'selected' : '' }}>Barang Keluar</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200">
                    Filter
                </button>
                @if(request()->hasAny(['start_date', 'end_date', 'transaction_type']))
                    <a href="{{ route('inventory.activity') }}" class="ml-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md text-sm font-medium transition-all duration-200">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Barang Masuk</p>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900">{{ $activities->where('transaction_type', 'IN')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Barang Keluar</p>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900">{{ $activities->where('transaction_type', 'OUT')->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Qty</p>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900">{{ $activities->sum('quantity') ?? 0 }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-3 sm:p-4">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-2 sm:ml-3">
                    <p class="text-xs sm:text-sm font-medium text-gray-600">Total Log</p>
                    <p class="text-sm sm:text-lg font-semibold text-gray-900">{{ $activities->count() ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h3 class="text-base sm:text-lg font-medium text-gray-900">Riwayat Aktivitas</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Waktu
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produk
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            User
                        </th>
                        <th class="px-3 sm:px-6 py-2 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan
                        </th>
                    </tr>
                </thead>                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities ?? [] as $activity)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ isset($activity->created_at) ? $activity->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            @if($activity->transaction_type === 'IN')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Masuk
                                </span>
                            @elseif($activity->transaction_type === 'OUT')
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    Keluar
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $activity->transaction_type ?? 'N/A' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $activity->product ? $activity->product->product_name : ($activity->product_name ?? 'Produk tidak ditemukan') }}
                            </div>
                            @if(isset($activity->barcode))
                                <div class="text-sm text-gray-500">{{ $activity->barcode }}</div>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                @if($activity->transaction_type === 'OUT')
                                    <span class="text-red-600">-{{ $activity->quantity ?? 0 }}</span>
                                @else
                                    <span class="text-green-600">+{{ $activity->quantity ?? 0 }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $activity->user_name ?? 'System' }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-2 sm:py-4">
                            <div class="text-sm text-gray-500">{{ $activity->notes ?? 'Tidak ada keterangan' }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-sm text-gray-500">Belum ada aktivitas yang tercatat</p>
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
