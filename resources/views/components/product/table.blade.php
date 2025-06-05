<div class="block lg:hidden space-y-4" id="mobileProductList">
    <!-- Card produk dummy -->
    <div class="product-card">
        <div class="flex justify-between items-center">
            <div>
                <div class="font-bold text-lg">Pulpen Gel</div>
                <div class="text-xs text-gray-500">Barcode: 1234567890</div>
                <div class="text-xs text-gray-500">Grade: A</div>
                <div class="text-xs text-gray-500">Supplier: Toko ATK</div>
                <span class="status-badge" data-status="aktif">Aktif</span>
            </div>
            <div class="flex flex-col gap-1">
                <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Edit</button>
                <button class="text-red-600 hover:text-red-800 font-semibold text-xs">Hapus</button>
            </div>
        </div>
    </div>
    <div class="product-card">
        <div class="flex justify-between items-center">
            <div>
                <div class="font-bold text-lg">Buku Tulis</div>
                <div class="text-xs text-gray-500">Barcode: 9876543210</div>
                <div class="text-xs text-gray-500">Grade: B</div>
                <div class="text-xs text-gray-500">Supplier: Gramedia</div>
                <span class="status-badge" data-status="nonaktif">Nonaktif</span>
            </div>
            <div class="flex flex-col gap-1">
                <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs">Edit</button>
                <button class="text-red-600 hover:text-red-800 font-semibold text-xs">Hapus</button>
            </div>
        </div>
    </div>
</div>

<div class="hidden lg:block overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200" id="productTable">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Barcode</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Grade</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" id="productTableBody">
            <!-- Data produk dummy -->
            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Pulpen Gel</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">1234567890</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">A</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">Toko ATK</td>
                <td class="px-6 py-4 whitespace-nowrap"><span class="status-badge" data-status="aktif">Aktif</span></td>
                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                    <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs editProductBtn" data-id="1">Edit</button>
                    <button class="text-red-600 hover:text-red-800 font-semibold text-xs deleteProductBtn" data-id="1">Hapus</button>
                </td>
            </tr>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Buku Tulis</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">9876543210</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">B</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-700">Gramedia</td>
                <td class="px-6 py-4 whitespace-nowrap"><span class="status-badge" data-status="nonaktif">Nonaktif</span></td>
                <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                    <button class="text-indigo-600 hover:text-indigo-800 font-semibold text-xs editProductBtn" data-id="2">Edit</button>
                    <button class="text-red-600 hover:text-red-800 font-semibold text-xs deleteProductBtn" data-id="2">Hapus</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
