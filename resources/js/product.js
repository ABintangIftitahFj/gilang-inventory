// resources/js/product.js

document.addEventListener('DOMContentLoaded', function () {
    console.log('Product JS loaded'); // Debugging message
    
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
    const productPanjang = document.getElementById('productPanjang');
    const productLebar = document.getElementById('productLebar');
    const productBerat = document.getElementById('productBerat');
    const productGrade = document.getElementById('productGrade');
    const productSupplier = document.getElementById('productSupplier');
    const productDateReceived = document.getElementById('productDateReceived');
    const productLocation = document.getElementById('productLocation');
    const productStatus = document.getElementById('productStatus');
    const productNotes = document.getElementById('productNotes');

    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    // Debug if elements were found
    console.log('Open create modal button exists:', !!openCreateModal);
    console.log('Product modal exists:', !!productModal);

    // Open create modal
    if (openCreateModal) {
        console.log('Adding click event to open create modal button');
        openCreateModal.addEventListener('click', function (e) {
            e.preventDefault();
            console.log('Open create modal clicked');
            
            modalTitle.textContent = 'Tambah Produk';
            productForm.reset();
            productId.value = '';
            
            // Set current date as default for new products
            const today = new Date().toISOString().split('T')[0];
            productDateReceived.value = today;
            
            // Show modal
            productModal.classList.remove('hidden');
            console.log('Modal should be visible now');
        });
    } else {
        console.error('Failed to find the open create modal button');
    }

    // Close modal form
    if (closeProductModal) {
        closeProductModal.addEventListener('click', () => {
            console.log('Closing modal via close button');
            productModal.classList.add('hidden');
        });
    }
    
    if (cancelProductBtn) {
        cancelProductBtn.addEventListener('click', () => {
            console.log('Closing modal via cancel button');
            productModal.classList.add('hidden');
        });
    }

    // Fungsi untuk mengambil data produk dari server
    function fetchProductData(id) {
        console.log('Fetching product data for ID:', id);
        
        // Menggunakan URL API yang benar dengan base URL dinamis
        const baseUrl = window.location.origin;
        return fetch(`${baseUrl}/api/v1/products/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    return result.data;
                } else {
                    throw new Error('Failed to get product data');
                }
            })
            .catch(error => {
                console.error('Error fetching product data:', error);
                showToast('Gagal mengambil data produk', 'error');
                return null;
            });
    }

    // Fungsi untuk mengisi form dengan data produk
    function populateProductForm(product) {
        if (!product) return;
        
        productId.value = product.id;
        productName.value = product.product_name;
        productBarcode.value = product.barcode;
        productPanjang.value = product.panjang;
        productLebar.value = product.lebar;
        productBerat.value = product.berat;
        productGrade.value = product.grade;
        productSupplier.value = product.supplier;
        productDateReceived.value = product.date_received;
        productLocation.value = product.location;
        productStatus.value = product.status;
        productNotes.value = product.notes || '';
    }

    // Handle form submission
    if (productForm) {
        productForm.addEventListener('submit', function(event) {
            event.preventDefault();
            console.log('Form submitted');
            
            // Create FormData object
            const formData = new FormData(productForm);
            
            // Convert FormData to JSON
            const productData = {};
            formData.forEach((value, key) => {
                productData[key] = value;
            });
            
            // Determine if we're creating or updating a product
            const isUpdate = productId.value !== '';
            // Menggunakan URL API yang baru
            const baseUrl = window.location.origin;
            const url = isUpdate ? `${baseUrl}/api/v1/products/${productId.value}` : `${baseUrl}/api/v1/products`;
            const method = isUpdate ? 'PUT' : 'POST';
            
            // Send the AJAX request
            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(productData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    showToast(isUpdate ? 'Produk berhasil diperbarui!' : 'Produk berhasil ditambahkan!');
                    productModal.classList.add('hidden');
                    
                    // Refresh the page to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast('Gagal menyimpan produk', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving product:', error);
                showToast('Terjadi kesalahan saat menyimpan produk', 'error');
            });
        });
    }

    // Edit button handler - untuk tombol yang sudah ada di halaman
    document.querySelectorAll('.editProductBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            console.log('Edit button clicked for product ID:', id);
            
            modalTitle.textContent = 'Edit Produk';
            
            // Fetch product data from server
            fetchProductData(id)
                .then(product => {
                    if (product) {
                        populateProductForm(product);
                        productModal.classList.remove('hidden');
                    }
                });
        });
    });

    // Add global event listener to handle dynamically added edit buttons
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('editProductBtn')) {
            const id = e.target.getAttribute('data-id');
            if (e.target.hasAttribute('data-listener')) return; // Skip if already handled
            
            console.log('Dynamic edit button clicked for product ID:', id);
            
            modalTitle.textContent = 'Edit Produk';
            
            // Fetch product data from server
            fetchProductData(id)
                .then(product => {
                    if (product) {
                        populateProductForm(product);
                        productModal.classList.remove('hidden');
                    }
                });
            
            e.target.setAttribute('data-listener', 'true');
        }
    });

    // Delete button handler - untuk tombol hapus yang sudah ada di halaman
    document.querySelectorAll('.deleteProductBtn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            console.log('Delete button clicked for product ID:', id);
            
            if (deleteModal && confirmDeleteBtn) {
                confirmDeleteBtn.setAttribute('data-id', id);
                deleteModal.classList.remove('hidden');
            }
        });
    });

    // Add global event listener for dynamically added delete buttons
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('deleteProductBtn')) {
            if (e.target.hasAttribute('data-listener')) return; // Skip if already handled
            
            const id = e.target.getAttribute('data-id');
            console.log('Dynamic delete button clicked for product ID:', id);
            
            if (deleteModal && confirmDeleteBtn) {
                confirmDeleteBtn.setAttribute('data-id', id);
                deleteModal.classList.remove('hidden');
            }
            
            e.target.setAttribute('data-listener', 'true');
        }
    });

    // Close delete modal
    if (closeDeleteModal) closeDeleteModal.addEventListener('click', () => deleteModal.classList.add('hidden'));
    if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => deleteModal.classList.add('hidden'));

    // Confirm delete
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            console.log('Confirming delete for product ID:', id);
            
            // Send AJAX request to delete product (menggunakan URL API yang baru)
            const baseUrl = window.location.origin;
            fetch(`${baseUrl}/api/v1/products/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    showToast('Produk berhasil dihapus!');
                    deleteModal.classList.add('hidden');
                    
                    // Refresh the page to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast('Gagal menghapus produk', 'error');
                }
            })
            .catch(error => {
                console.error('Error deleting product:', error);
                showToast('Terjadi kesalahan saat menghapus produk', 'error');
            });
        });
    }

    // Toast notification function
    window.showToast = function(message, type = 'success') {
        if (!toast || !toastMessage) {
            console.error('Toast elements not found');
            return;
        }
        
        console.log('Showing toast:', message, type);
        
        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        
        // Optional: Change toast color based on type
        if (type === 'success') {
            toast.classList.add('text-green-500');
            toast.classList.remove('text-red-500', 'text-yellow-500');
        } else if (type === 'error') {
            toast.classList.add('text-red-500');
            toast.classList.remove('text-green-500', 'text-yellow-500');
        } else if (type === 'warning') {
            toast.classList.add('text-yellow-500');
            toast.classList.remove('text-green-500', 'text-red-500');
        }
        
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    };
    
    // Check if page was opened with an action parameter to open a specific modal
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action');
    if (action === 'create' && productModal) {
        modalTitle.textContent = 'Tambah Produk';
        productForm.reset();
        productId.value = '';
        const today = new Date().toISOString().split('T')[0];
        productDateReceived.value = today;
        productModal.classList.remove('hidden');
    }
});
