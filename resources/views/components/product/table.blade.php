@php
    $products = \App\Models\Product::all();
@endphp

<div class="block lg:hidden space-y-4" id="mobileProductList">
    @if($products->isEmpty())
        <div class="p-4 text-center text-gray-500">
            Tidak ada produk yang tersedia.
        </div>
    @else
        @foreach($products as $product)
        <div class="product-card">
            <div class="flex justify-between items-center">
                <div>
                    <div class="font-bold text-lg">{{ $product->product_name }}</div>
                    <div class="text-xs text-gray-500">Barcode: {{ $product->barcode }}</div>
                    <div class="text-xs text-gray-500">Panjang: {{ $product->panjang }}</div>
                    <div class="text-xs text-gray-500">Lebar: {{ $product->lebar }}</div>
                    <div class="text-xs text-gray-500">Berat: {{ $product->berat }}</div>
                    <div class="text-xs text-gray-500">Grade: {{ $product->grade }}</div>
                    <div class="text-xs text-gray-500">Supplier: {{ $product->supplier }}</div>
                    <div class="text-xs text-gray-500">Lokasi: {{ $product->location }}</div>
                    <div class="text-xs text-gray-500">Tanggal Diterima: {{ $product->date_received }}</div>
                    <div class="text-xs text-gray-500">Catatan: {{ $product->notes }}</div>
                    <span class="status-badge" data-status="{{ $product->status === 'in_stock' ? 'in stock' : 'out of stock' }}">
                        {{ $product->status === 'in_stock' ? 'in stock' : 'out of stock' }}
                    </span>
                </div>
                <div class="flex flex-col gap-1">
                    <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs editProductBtn" data-id="{{ $product->id }}">Edit</button>
                    <button class="text-red-600 hover:text-red-800 font-semibold text-xs deleteProductBtn" data-id="{{ $product->id }}">Hapus</button>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<div class="hidden lg:block overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200" id="productTable">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Barcode</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Panjang</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lebar</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Berat</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Grade</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Diterima</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Catatan</th>
                <th class="px-6 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="productTableBody">
            @if($products->isEmpty())
                <tr>
                    <td colspan="12" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada produk yang tersedia.
                    </td>
                </tr>
            @else
                @foreach($products as $product)
                <tr>
                    <td class="px-6 py-3 whitespace-nowrap font-medium text-gray-900">{{ $product->product_name }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->barcode }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->panjang }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->lebar }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->berat }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->grade }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->supplier }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->location }}</td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->date_received }}</td>
                    <td class="px-6 py-3 whitespace-nowrap">
                        <span class="status-badge" data-status="{{ $product->status === 'in_stock' ? 'aktif' : 'nonaktif' }}">
                            {{ $product->status === 'in_stock' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-3 whitespace-nowrap text-gray-700">{{ $product->notes }}</td>
                    <td class="px-6 py-3 whitespace-nowrap flex gap-2">
                        <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs editProductBtn" data-id="{{ $product->id }}">Edit</button>
                        <button class="text-red-600 hover:text-red-800 font-semibold text-xs deleteProductBtn" data-id="{{ $product->id }}">Hapus</button>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
