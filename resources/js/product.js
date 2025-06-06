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
    const panjangField = document.getElementById('panjang');
    const lebarField = document.getElementById('lebar');
    const beratField = document.getElementById('berat');
    const locationField = document.getElementById('location');
    const dateReceivedField = document.getElementById('date_received');
    const notesField = document.getElementById('notes');

    const deleteModal = document.getElementById('deleteModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    // CSRF Token - dengan pengecekan null
    let csrfToken = '';
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
        csrfToken = metaTag.getAttribute('content');
    } else {
        console.warn('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    // Open create modal
    if (openCreateModal) {
        openCreateModal.addEventListener('click', function () {
            modalTitle.textContent = 'Tambah Produk';
            productForm.reset();
            productId.value = '';
            
            // Set form action for create
            productForm.setAttribute('action', '/products');
            productForm.setAttribute('method', 'POST');
            
            productModal.classList.remove('hidden');
        });
    }

    // Close modal form
    if (closeProductModal) closeProductModal.addEventListener('click', () => productModal.classList.add('hidden'));
    if (cancelProductBtn) cancelProductBtn.addEventListener('click', () => productModal.classList.add('hidden'));

    // Edit button - Use event delegation for all elements including dynamically added ones
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('editProductBtn')) {
            const id = e.target.getAttribute('data-id');
            
            if (!id) {
                console.error('No product ID found');
                return;
            }
            
            modalTitle.textContent = 'Edit Produk';
            
            // Show loading state
            productForm.classList.add('opacity-50');
            productForm.querySelectorAll('input, select').forEach(el => el.disabled = true);
            
            // Fetch product data from server
            fetch(`/products/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Fill the form with product data
                    productId.value = data.id;
                    productName.value = data.product_name;
                    productBarcode.value = data.barcode;
                    productGrade.value = data.grade;
                    productSupplier.value = data.supplier;
                    productStatus.value = data.status; // Use database value as is
                    
                    // Fill additional fields if they exist
                    if (panjangField) panjangField.value = data.panjang;
                    if (lebarField) lebarField.value = data.lebar;
                    if (beratField) beratField.value = data.berat;
                    if (locationField) locationField.value = data.location;
                    if (dateReceivedField) dateReceivedField.value = data.date_received;
                    if (notesField) notesField.value = data.notes;
                    
                    // Set form action for update
                    productForm.setAttribute('action', `/products/${id}`);
                    productForm.setAttribute('method', 'POST');
                    
                    // Add hidden method field for PUT request if it doesn't exist
                    let methodField = productForm.querySelector('input[name="_method"]');
                    if (!methodField) {
                        methodField = document.createElement('input');
                        methodField.setAttribute('type', 'hidden');
                        methodField.setAttribute('name', '_method');
                        productForm.appendChild(methodField);
                    }
                    methodField.value = 'PUT';
                    
                    // Remove loading state
                    productForm.classList.remove('opacity-50');
                    productForm.querySelectorAll('input, select').forEach(el => el.disabled = false);
                    
                    // Show the modal
                    productModal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching product:', error);
                    showToast('Error memuat data produk', 'error');
                });
        }
    });

    // Handle form submit with AJAX
    if (productForm) {
        productForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(productForm);
            const url = productForm.getAttribute('action');
            const method = productForm.getAttribute('method');
            
            // Hapus konversi status yang tidak perlu karena form sudah mengirim nilai yang benar
            
            const headers = {};
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
                // Tambahkan header Accept untuk menerima JSON response
                headers['Accept'] = 'application/json';
            }
            
            fetch(url, {
                method: method,
                headers: headers,
                body: formData
            })
            .then(async response => {
                // Jika response sukses
                if (response.ok) {
                    return response.json();
                } 
                // Jika validasi gagal
                else if (response.status === 422) {
                    const data = await response.json();
                    
                    // Log full error untuk troubleshooting
                    console.log("Validation errors:", data.errors);
                    
                    // Tampilkan error messages pada form
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            const errorElement = document.getElementById(`error-${key}`);
                            if (errorElement) {
                                errorElement.textContent = data.errors[key][0];
                            }
                        });
                    }
                    
                    throw new Error("Validation failed");
                } 
                // Jika error lainnya
                else {
                    const data = await response.json();
                    throw new Error(data.message || 'Gagal menyimpan produk');
                }
            })
            .then(data => {
                if (data.success) {
                    productModal.classList.add('hidden');
                    showToast(data.message || 'Produk berhasil disimpan');
                    
                    // Reload the page to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showToast(data.message || 'Terjadi kesalahan', 'error');
                }
            })
            .catch(error => {
                console.error('Error saving product:', error);
                showToast('Terjadi kesalahan saat menyimpan data: ' + error.message, 'error');
            });
        });
    }

    // Delete button using event delegation
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('deleteProductBtn')) {
            const id = e.target.getAttribute('data-id');
            if (id) {
                deleteModal.classList.remove('hidden');
                confirmDeleteBtn.setAttribute('data-id', id);
            }
        }
    });

    // Close delete modal
    if (closeDeleteModal) closeDeleteModal.addEventListener('click', () => deleteModal.classList.add('hidden'));
    if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => deleteModal.classList.add('hidden'));

    // Confirm delete with AJAX
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            const id = confirmDeleteBtn.getAttribute('data-id');
            
            if (!id) {
                console.error('No product ID found for deletion');
                return;
            }
            
            const headers = {
                'Content-Type': 'application/json'
            };
            
            if (csrfToken) {
                headers['X-CSRF-TOKEN'] = csrfToken;
                headers['Accept'] = 'application/json';
            }
            
            fetch(`/products/${id}`, {
                method: 'DELETE',
                headers: headers
            })
            .then(response => response.json())
            .then(data => {
                deleteModal.classList.add('hidden');
                showToast(data.message || 'Produk berhasil dihapus!');
                
                // Reload the page to refresh the product list
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            })
            .catch(error => {
                console.error('Error deleting product:', error);
                showToast('Terjadi kesalahan saat menghapus produk', 'error');
                deleteModal.classList.add('hidden');
            });
        });
    }

    // Toast notification function
    window.showToast = function(message, type = 'success') {
        if (!toast || !toastMessage) {
            console.error('Toast elements not found');
            return;
        }
        
        toastMessage.textContent = message;
        toast.classList.remove('hidden');
        
        // Set toast color based on type
        const toastDiv = toast.querySelector('div');
        if (toastDiv) {
            if (type === 'error') {
                toastDiv.classList.remove('bg-green-500');
                toastDiv.classList.add('bg-red-500');
            } else {
                toastDiv.classList.remove('bg-red-500');
                toastDiv.classList.add('bg-green-500');
            }
        }
        
        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    };
});
