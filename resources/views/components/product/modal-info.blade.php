<div id="productInfoModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6 relative overflow-y-auto max-h-[90vh]">
        <button id="closeProductInfoModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 class="text-xl font-bold mb-4">Detail Produk</h2>
        <div id="productInfoContent" class="space-y-4">
            <div class="border-b pb-2">
                <p class="text-sm text-gray-500">Nama Produk</p>
                <p id="infoProductName" class="font-semibold"></p>
            </div>
            <div class="border-b pb-2">
                <p class="text-sm text-gray-500">Barcode</p>
                <p id="infoProductBarcode" class="font-semibold"></p>
            </div>
            <div class="grid grid-cols-3 gap-4 border-b pb-2">
                <div>
                    <p class="text-sm text-gray-500">Panjang</p>
                    <p id="infoProductPanjang" class="font-semibold"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lebar</p>
                    <p id="infoProductLebar" class="font-semibold"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Berat</p>
                    <p id="infoProductBerat" class="font-semibold"></p>
                </div>
            </div>
            <div class="border-b pb-2">
                <p class="text-sm text-gray-500">Grade</p>
                <p id="infoProductGrade" class="font-semibold"></p>
            </div>
            <div class="border-b pb-2">
                <p class="text-sm text-gray-500">Supplier</p>
                <p id="infoProductSupplier" class="font-semibold"></p>
            </div>
            <div class="border-b pb-2">
                <p class="text-sm text-gray-500">Tanggal Terima</p>
                <p id="infoProductDateReceived" class="font-semibold"></p>
            </div>
            <div class="border-b pb-2">
                <p class="text-sm text-gray-500">Lokasi</p>
                <p id="infoProductLocation" class="font-semibold"></p>
            </div>
            <div class="border-b pb-2">
                <p class="text-sm text-gray-500">Status</p>
                <p id="infoProductStatus" class="font-semibold"></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Catatan</p>
                <p id="infoProductNotes" class="font-semibold"></p>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" id="closeInfoBtn" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">Tutup</button>
                <button type="button" id="editProductBtn" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold">Edit</button>
            </div>
        </div>
    </div>
</div>