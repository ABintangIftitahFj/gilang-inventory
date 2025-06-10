@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Transaksi</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola riwayat transaksi masuk dan keluar</p>
        </div>
        <a href="{{ route('transactions.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow font-semibold transition-all duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Transaksi
        </a>
    </div>

    <!-- Mobile View for Transactions -->
    <div class="block lg:hidden space-y-4" id="mobileTransactionList">
        @forelse($transactions as $transaction)
        <div class="transaction-card bg-white rounded-xl shadow-md p-4 border border-gray-100">
            <div class="flex flex-col gap-3">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-bold text-lg text-gray-900">{{ $transaction->product_name ?? 'Produk tidak tersedia' }}</div>
                        <div class="text-sm font-medium text-gray-700">Barcode: {{ $transaction->barcode }}</div>
                    </div>
                    <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $transaction->transaction_type == 'IN' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $transaction->transaction_type == 'IN' ? 'Masuk' : 'Keluar' }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <div class="text-xs text-gray-500">Jumlah: {{ $transaction->quantity }}</div>
                    <div class="text-xs text-gray-500">User: {{ $transaction->user_name }}</div>
                    <div class="text-xs text-gray-500">Catatan: {{ $transaction->notes ?? '-' }}</div>
                    <div class="text-xs text-gray-500">Tanggal: {{ $transaction->created_at ? $transaction->created_at->format('Y-m-d H:i') : 'N/A' }}</div>
                </div>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('transactions.edit', $transaction->id) }}" class="w-full bg-blue-100 text-blue-700 hover:bg-blue-200 px-4 py-2 rounded-lg font-semibold text-sm flex items-center justify-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg font-semibold text-sm flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-500 py-4">Tidak ada transaksi tersedia</div>
        @endforelse
    </div>

    <!-- Desktop View for Transactions -->
    <div class="hidden lg:block bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Barcode</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Catatan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->created_at ? $transaction->created_at->format('Y-m-d H:i') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                @if($transaction->transaction_type == 'IN')
                                    {{ $transaction->product ? $transaction->product->product_name : ($transaction->product_name ?? 'Produk tidak tersedia') }}
                                @else
                                    {{ $transaction->product_name ?? ($transaction->product ? $transaction->product->product_name : 'Produk tidak tersedia') }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction->barcode }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($transaction->transaction_type == 'IN')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $transaction->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction->user_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $transaction->notes ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    Edit
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection