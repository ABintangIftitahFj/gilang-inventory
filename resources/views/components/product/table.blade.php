<div class="block lg:hidden space-y-4" id="mobileProductList">
    <!-- Card produk dari database -->
    @forelse($products as $product)
    <div class="product-card">
        <div class="flex justify-between items-center">
            <div>
                <div class="font-bold text-lg">{{ $product->product_name }}</div>
                <div class="text-xs text-gray-500">Barcode: {{ $product->barcode }}</div>
                <div class="text-xs text-gray-500">Dimensi: {{ $product->panjang }}x{{ $product->lebar }} cm</div>
                <div class="text-xs text-gray-500">Berat: {{ $product->berat }} gram</div>
                <div class="text-xs text-gray-500">Grade: {{ $product->grade }}</div>
                <div class="text-xs text-gray-500">Supplier: {{ $product->supplier }}</div>
                <div class="text-xs text-gray-500">Lokasi: {{ $product->location }}</div>
                <div class="text-xs text-gray-500">Tanggal Terima: {{ $product->date_received }}</div>
                <span class="status-badge" data-status="{{ $product->status == 'in_stock' ? 'aktif' : 'nonaktif' }}">
                    {{ $product->status == 'in_stock' ? 'In Stock' : 'Out Of Stock' }}
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs editProductBtn" data-id="{{ $product->id }}">Edit</button>
                <button class="text-red-600 hover:text-red-800 font-semibold text-xs deleteProductBtn" data-id="{{ $product->id }}">Hapus</button>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center text-gray-500 py-4">Tidak ada produk tersedia</div>
    @endforelse
</div>

<div class="hidden lg:block overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200" id="productTable">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Barcode</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dimensi (PxL)</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Berat</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Grade</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Lokasi</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Terima</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="productTableBody">
            <!-- Data produk dari database -->
            @forelse($products as $product)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $product->product_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product->barcode }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product->panjang }}x{{ $product->lebar }} cm</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product->berat }} gram</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product->grade }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product->supplier }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product->location }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $product->date_received }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="status-badge" data-status="{{ $product->status == 'in_stock' ? 'aktif' : 'nonaktif' }}">
                        {{ $product->status == 'in_stock' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                    <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs editProductBtn" data-id="{{ $product->id }}">Edit</button>
                    <button class="text-red-600 hover:text-red-800 font-semibold text-xs deleteProductBtn" data-id="{{ $product->id }}">Hapus</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="px-6 py-4 text-center text-gray-500">Tidak ada produk tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
