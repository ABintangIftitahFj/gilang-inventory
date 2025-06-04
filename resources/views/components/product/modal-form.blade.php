<div id="productModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6 relative">
        <button id="closeProductModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Tambah Produk</h2>
        <form id="productForm" class="space-y-4">
            <input type="hidden" id="productId" name="id">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Produk</label>
                <input type="text" id="productName" name="name" class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Barcode</label>
                <input type="text" id="productBarcode" name="barcode" class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Grade</label>
                <input type="text" id="productGrade" name="grade" class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Supplier</label>
                <input type="text" id="productSupplier" name="supplier" class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select id="productStatus" name="status" class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelProductBtn" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>
