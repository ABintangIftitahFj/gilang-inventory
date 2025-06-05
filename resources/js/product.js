// resources/js/product.js

document.addEventListener('DOMContentLoaded', function () {
    // Modal elements
    const productModal = document.getElementById('productModal');
    const openCreateModal = document.getElementById('openCreateModal');
    const closeProductModal = document.getElementById('closeProductModal');
    const cancelProductBtn = document.getElementById('cancelProductBtn');
    const modalTitle = document.getElementById('modalTitle');
    const productForm = document.getElementById('productForm');
    const productId = document.getElementById('productId');
    const productName = document.getElementById('productName');
    const productBarcode = document.getElementById('productBarcode');
    const productGrade = document.getElementById('productGrade');
    const productSupplier = document.getElementById('productSupplier');
    const productStatus = document.getElementById('productStatus');

    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    // Open create modal
    if (openCreateModal) {
        openCreateModal.addEventListener('click', function () {
            modalTitle.textContent = 'Tambah Produk';
            productForm.reset();
            productId.value = '';
            productModal.classList.remove('hidden');
        });
    }

    // Close modal form
    if (closeProductModal) closeProductModal.addEventListener('click', () => productModal.classList.add('hidden'));
    if (cancelProductBtn) cancelProductBtn.addEventListener('click', () => productModal.classList.add('hidden'));

    // Edit button
    document.querySelectorAll('.editProductBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            modalTitle.textContent = 'Edit Produk';
            // Dummy data, replace with real data if available
            const id = btn.getAttribute('data-id');
            if (id === '1') {
                productId.value = '1';
                productName.value = 'Pulpen Gel';
                productBarcode.value = '1234567890';
                productGrade.value = 'A';
                productSupplier.value = 'Toko ATK';
                productStatus.value = 'aktif';
            } else {
                productId.value = '2';
                productName.value = 'Buku Tulis';
                productBarcode.value = '9876543210';
                productGrade.value = 'B';
                productSupplier.value = 'Gramedia';
                productStatus.value = 'nonaktif';
            }
            productModal.classList.remove('hidden');
        });
    });

    // Delete button
    document.querySelectorAll('.deleteProductBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            deleteModal.classList.remove('hidden');
            confirmDeleteBtn.setAttribute('data-id', btn.getAttribute('data-id'));
        });
    });

    // Close delete modal
    if (closeDeleteModal) closeDeleteModal.addEventListener('click', () => deleteModal.classList.add('hidden'));
    if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => deleteModal.classList.add('hidden'));

    // Confirm delete
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            // Dummy delete, replace with real delete logic
            showToast('Produk berhasil dihapus!');
            deleteModal.classList.add('hidden');
        });
    }

    // Toast notification function
    window.showToast = function(message, type = 'success') {
        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 2000);
    };
});
