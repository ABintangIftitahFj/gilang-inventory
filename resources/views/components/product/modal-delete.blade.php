<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 p-6 relative">
        <button id="closeDeleteModal" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 class="text-lg font-bold mb-4">Konfirmasi Hapus</h2>
        <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus produk ini?</p>
        <div class="flex justify-end gap-2">
            <button id="cancelDeleteBtn" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
            <button id="confirmDeleteBtn" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold">Hapus</button>
        </div>
    </div>
</div>
