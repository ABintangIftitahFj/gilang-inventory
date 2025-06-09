@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-3xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Transaksi</h1>
        <p class="mt-1 text-sm text-gray-600">Catat transaksi masuk atau keluar produk</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            
            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                    <select id="product_id" name="product_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">Pilih Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-barcode="{{ $product->barcode }}">
                                {{ $product->product_name }} ({{ $product->barcode }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="barcode" class="block text-sm font-medium text-gray-700 mb-1">Barcode</label>
                    <input type="text" id="barcode" name="barcode" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required readonly>
                </div>

                <div>
                    <label for="transaction_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Transaksi</label>
                    <select id="transaction_type" name="transaction_type" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="IN">Masuk</option>
                        <option value="OUT">Keluar</option>
                    </select>
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" id="quantity" name="quantity" min="1" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div>
                    <label for="user_name" class="block text-sm font-medium text-gray-700 mb-1">Nama User</label>
                    <input type="text" id="user_name" name="user_name" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('transactions.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const barcode = selectedOption.getAttribute('data-barcode');
    document.getElementById('barcode').value = barcode || '';
});
</script>
@endpush

@endsection