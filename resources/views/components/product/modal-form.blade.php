<div id="productModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden overflow-y-auto">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6 relative max-h-screen">
        <button id="closeProductModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 class="text-xl font-bold mb-4" id="modalTitle">Tambah Produk</h2>
        
        <form id="productForm" method="POST" class="space-y-4 overflow-y-auto">
            @csrf
            <input type="hidden" id="productId" name="id">

            <div>
                <label class="block text-sm font-medium mb-1">Nama Produk</label>
                <input type="text" id="productName" name="product_name" class="input-field" required>
                <span class="text-red-500 text-sm error-message" id="error-product_name"></span>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Barcode</label>
                <input type="text" id="productBarcode" name="barcode" class="input-field" required>
                <span class="text-red-500 text-sm error-message" id="error-barcode"></span>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Panjang</label>
                    <input type="number" step="0.01" id="panjang" name="panjang" class="input-field" required>
                    <span class="text-red-500 text-sm error-message" id="error-panjang"></span>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Lebar</label>
                    <input type="number" step="0.01" id="lebar" name="lebar" class="input-field" required>
                    <span class="text-red-500 text-sm error-message" id="error-lebar"></span>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Berat</label>
                    <input type="number" step="0.01" id="berat" name="berat" class="input-field" required>
                    <span class="text-red-500 text-sm error-message" id="error-berat"></span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Grade</label>
                <input type="text" id="productGrade" name="grade" class="input-field" required>
                <span class="text-red-500 text-sm error-message" id="error-grade"></span>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Supplier</label>
                <input type="text" id="productSupplier" name="supplier" class="input-field" required>
                <span class="text-red-500 text-sm error-message" id="error-supplier"></span>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Lokasi</label>
                <input type="text" id="location" name="location" class="input-field" required>
                <span class="text-red-500 text-sm error-message" id="error-location"></span>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Diterima</label>
                <input type="date" id="date_received" name="date_received" class="input-field" required>
                <span class="text-red-500 text-sm error-message" id="error-date_received"></span>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select id="productStatus" name="status" class="input-field">
                    <option value="in_stock">In Stock</option>
                    <option value="out_of_stock">Out Of Stock</option>
                </select>
                <span class="text-red-500 text-sm error-message" id="error-status"></span>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Catatan</label>
                <textarea id="notes" name="notes" class="input-field" rows="3"></textarea>
                <span class="text-red-500 text-sm error-message" id="error-notes"></span>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="cancelProductBtn" class="btn-gray">Batal</button>
                <button type="submit" class="btn-indigo">Simpan</button>
            </div>
        </form>
    </div>
</div>

<style>
.input-field {
    width: 100%;
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    border: 1px solid #e5e7eb;
    outline: none;
    transition: all 0.2s ease;
}
.input-field:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 1px #6366f1;
}
.btn-indigo {
    background-color: #4f46e5;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
}
.btn-indigo:hover {
    background-color: #4338ca;
}
.btn-gray {
    background-color: #e5e7eb;
    color: #374151;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
}
</style>
