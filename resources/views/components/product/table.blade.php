<div class="block lg:hidden space-y-4" id="mobileProductList">
    <!-- Card produk dari database -->
    @forelse($products as $product)
    <div class="product-card bg-white rounded-xl shadow-md p-4 border border-gray-100">
        <div class="flex flex-col gap-3">
            <div class="flex justify-between items-start">
                <div>
                    <div class="font-bold text-lg text-gray-900">{{ $product->product_name }}</div>
                    <div class="text-sm font-medium text-gray-700">Barcode: {{ $product->barcode }}</div>
                </div>
                <span class="status-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->status == 'in_stock' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->status == 'in_stock' ? 'In Stock' : 'Out Of Stock' }}
                </span>
            </div>
            
            <div class="grid grid-cols-2 gap-2 mt-2">
                <div class="text-xs text-gray-500">Dimensi: {{ $product->panjang }}x{{ $product->lebar }} cm</div>
                <div class="text-xs text-gray-500">Berat: {{ $product->berat }} gram</div>
                <div class="text-xs text-gray-500">Grade: {{ $product->grade }}</div>
                <div class="text-xs text-gray-500">Supplier: {{ $product->supplier }}</div>
                <div class="text-xs text-gray-500">Lokasi: {{ $product->location }}</div>
                <div class="text-xs text-gray-500">Tanggal: {{ $product->date_received }}</div>
            </div>
            <div class="flex flex-col gap-1">
                <button class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1.5 rounded-lg font-semibold text-sm editProductBtn flex items-center justify-center gap-1" data-id="{{ $product->id }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </button>
                <button class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg font-semibold text-sm deleteProductBtn flex items-center justify-center gap-1" data-id="{{ $product->id }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
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
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex gap-2">
                        <button class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1.5 rounded-lg font-semibold text-sm editProductBtn flex items-center justify-center gap-1" data-id="{{ $product->id }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </button>
                        <button class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1.5 rounded-lg font-semibold text-sm deleteProductBtn flex items-center justify-center gap-1" data-id="{{ $product->id }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </div>
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
