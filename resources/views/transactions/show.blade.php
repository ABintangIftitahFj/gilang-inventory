@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Detail Transaksi</h1>
            <p class="mt-0.5 sm:mt-1 text-xs sm:text-sm text-gray-600">Informasi lengkap transaksi</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium flex items-center gap-1 bg-indigo-50 py-1.5 px-3 rounded-md self-start sm:self-auto">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="text-sm sm:text-base">Kembali</span>
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="border-b border-gray-200">
            <dl>
                <div class="bg-gray-50 px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Produk</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">
                        {{ $transaction->product ? $transaction->product->product_name : 'Produk tidak tersedia' }}
                    </dd>
                </div>
                <div class="bg-white px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Barcode</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">{{ $transaction->barcode }}</dd>
                </div>
                <div class="bg-gray-50 px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Tipe Transaksi</dt>
                    <dd class="text-sm sm:col-span-2">
                        @if($transaction->transaction_type == 'IN')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Masuk
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Keluar
                            </span>
                        @endif
                    </dd>
                </div>
                <div class="bg-white px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Jumlah</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">{{ $transaction->quantity }}</dd>
                </div>
                <div class="bg-gray-50 px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Nama User</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">{{ $transaction->user_name }}</dd>
                </div>
                <div class="bg-white px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">{{ $transaction->notes ?? '-' }}</dd>
                </div>
                <div class="bg-gray-50 px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</dd>
                </div>
                <div class="bg-white px-6 py-5 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">{{ $transaction->updated_at->format('Y-m-d H:i:s') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-4">
        <a href="{{ route('transactions.edit', $transaction->id) }}" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Edit Transaksi
        </a>
        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                Hapus Transaksi
            </button>
        </form>
    </div>
</div>
@endsection