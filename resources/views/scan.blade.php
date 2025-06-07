@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center mb-4">
                <a href="{{ route('dashboard') }}" class="mr-4 p-2 rounded-lg hover:bg-white/50 transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Scanner Barcode</h1>
                    <p class="text-gray-600">Scan barcode produk untuk kelola inventory</p>
                </div>
            </div>
        </div>

        <!-- Scanner Area -->
        <div class="max-w-md mx-auto mb-8">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <!-- Scanner Status -->
                <div id="scannerStatus" class="p-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                        </svg>
                        <span class="font-semibold">Siap untuk scan</span>
                    </div>
                </div>

                <!-- Scanner Preview Area -->
                <div id="interactive" class="relative bg-gray-900 aspect-square flex items-center justify-center overflow-hidden">
                    <div class="absolute inset-4 border-2 border-white rounded-lg opacity-50 z-10 pointer-events-none"></div>
                    <!-- Scanner Line Animation -->
                    <div class="absolute left-4 right-4 h-0.5 bg-green-400 animate-bounce z-10 pointer-events-none" style="top: 45%;"></div>
                    
                    <!-- Added a container for the video with full width styling -->
                    <div class="video-container w-full h-full absolute inset-0">
                        <!-- Camera display will be injected here by Quagga2 -->
                    </div>
                </div>

                <!-- Scan Result -->
                <div class="p-4 bg-gray-50">
                    <p class="text-sm text-gray-600 text-center">
                        <span class="font-semibold text-green-600">Barcode:</span> 
                        <span id="result">Siap untuk scan</span>
                    </p>
                </div>

                <!-- Camera Controls -->
                <div class="p-4 bg-gray-100 border-t border-gray-200">
                    <div class="flex justify-center space-x-4">
                        <button id="startButton" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow text-sm font-medium transition-all duration-200">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                Mulai Kamera
                            </span>
                        </button>
                        <button id="switchCameraButton" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm font-medium transition-all duration-200">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Ganti Kamera
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Add New Product Button -->
            <div class="mt-4 text-center">
                <button id="addNewProductBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow font-semibold transition-all duration-300 flex items-center gap-2 mx-auto hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Produk Baru
                </button>
            </div>
        </div>

        <!-- Product Found Section (Initially Hidden) -->
        <div id="productFoundSection" class="max-w-4xl mx-auto hidden">
            <!-- Product information will be dynamically loaded here -->
        </div>
    </div>
</div>

<!-- Product Form Modal -->
<x-product.modal-form />

<!-- Toast Notification (Hidden by default) -->
<div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
    <div class="flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <span id="toastMessage">Scan berhasil!</span>
    </div>
</div>

@endsection

@push('scripts')
<!-- Include QuaggaJS for barcode scanning -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.8.2/dist/quagga.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
<<<<<<< Updated upstream
    // Show toast notification
    setTimeout(() => {
        const toast = document.getElementById('toast');
        toast.classList.remove('translate-x-full');
=======
    const scannerStatus = document.getElementById('scannerStatus');
    const resultElement = document.getElementById('result');
    const addNewProductBtn = document.getElementById('addNewProductBtn');
    const productFoundSection = document.getElementById('productFoundSection');
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    const startButton = document.getElementById('startButton');
    const switchCameraButton = document.getElementById('switchCameraButton');
    
    // Product form elements
    const productModal = document.getElementById('productModal');
    const productBarcode = document.getElementById('productBarcode');
    const modalTitle = document.getElementById('modalTitle');
    const productForm = document.getElementById('productForm');

    // Camera variables
    let activeCamera = 'environment'; // Default to back camera
    let isScanning = false;
    
    // Function to show toast notification
    function showToast(message, type = 'success') {
        toastMessage.textContent = message;
        toast.classList.remove('translate-x-full');
        toast.classList.remove('bg-green-500', 'bg-red-500');
        toast.classList.add(type === 'success' ? 'bg-green-500' : 'bg-red-500');
>>>>>>> Stashed changes
        
        // Hide toast after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
        }, 3000);
<<<<<<< Updated upstream
    }, 500);

    // Button click handlers (you can replace with actual form submissions)
    document.querySelector('.bg-gradient-to-r.from-green-500').addEventListener('click', function() {
        // Redirect to IN transaction form
        console.log('Redirecting to IN transaction form...');
        // window.location.href = '/transaction/in/8901234567890';
    });

    document.querySelector('.bg-gradient-to-r.from-red-500').addEventListener('click', function() {
        // Redirect to OUT transaction form
        console.log('Redirecting to OUT transaction form...');
        // window.location.href = '/transaction/out/8901234567890';
    });
=======
    }
    
    // Function to check if barcode exists in database
    function checkBarcode(barcode) {
        return fetch(`/api/products/check-barcode/${barcode}`)
            .then(response => response.json())
            .catch(error => {
                console.error('Error checking barcode:', error);
                return { exists: false };
            });
    }
    
    // Get available video devices
    async function getVideoDevices() {
        try {
            const devices = await navigator.mediaDevices.enumerateDevices();
            return devices.filter(device => device.kind === 'videoinput');
        } catch (error) {
            console.error('Error enumerating devices:', error);
            return [];
        }
    }
    
    // Initialize Quagga barcode scanner
    async function initScanner() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showToast('Browser tidak mendukung akses kamera', 'error');
            return;
        }
        
        try {
            // Stop scanner if already running
            if (isScanning) {
                await stopScanner();
            }
            
            isScanning = true;
            scannerStatus.querySelector('span').textContent = 'Memulai kamera...';
            
            const videoDevices = await getVideoDevices();
            console.log('Available video devices:', videoDevices);

            // Configure Quagga
            await Quagga.init({
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('.video-container'),
                    constraints: {
                        width: { min: 640 },
                        height: { min: 480 },
                        aspectRatio: { min: 1, max: 1 },
                        facingMode: activeCamera
                    },
                },
                locator: {
                    patchSize: "medium",
                    halfSample: true
                },
                numOfWorkers: 2,
                frequency: 10,
                decoder: {
                    readers: [
                        "code_128_reader",
                        "ean_reader",
                        "ean_8_reader",
                        "code_39_reader",
                        "code_39_vin_reader",
                        "codabar_reader",
                        "upc_reader",
                        "upc_e_reader",
                        "i2of5_reader"
                    ],
                    debug: {
                        showCanvas: true,
                        showPatches: true,
                        showFoundPatches: true,
                        showSkeleton: true,
                        showLabels: true,
                        showPatchLabels: true,
                        showRemainingPatchLabels: true,
                        boxFromPatches: {
                            showTransformed: true,
                            showTransformedBox: true,
                            showBB: true
                        }
                    }
                },
            }, function(err) {
                if (err) {
                    console.error('Error initializing Quagga:', err);
                    showToast('Gagal mengaktifkan kamera. Coba izinkan akses di pengaturan browser.', 'error');
                    isScanning = false;
                    return;
                }
                
                // Camera is now active, update UI
                scannerStatus.querySelector('span').textContent = 'Siap untuk scan';
                startButton.innerHTML = `
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                        </svg>
                        Stop Kamera
                    </span>`;
                
                // Start scanning
                Quagga.start();
                
                // Make sure video is visible and properly sized
                setTimeout(() => {
                    const video = document.querySelector('.video-container video');
                    if (video) {
                        video.style.display = 'block';
                        video.style.width = '100%';
                        video.style.height = '100%';
                        video.style.objectFit = 'cover';
                        
                        // Add parent styling to ensure video container fills scanner area
                        const videoContainer = document.querySelector('.video-container');
                        if (videoContainer) {
                            videoContainer.style.display = 'flex';
                            videoContainer.style.justifyContent = 'center';
                            videoContainer.style.alignItems = 'center';
                        }
                    }
                }, 1000);
            });
        } catch (error) {
            console.error('Failed to initialize scanner:', error);
            showToast('Gagal mengaktifkan kamera: ' + error.message, 'error');
            isScanning = false;
        }
    }
    
    // Function to stop the scanner
    async function stopScanner() {
        if (isScanning) {
            try {
                await Quagga.stop();
                isScanning = false;
                startButton.innerHTML = `
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Mulai Kamera
                    </span>`;
                console.log('Scanner stopped');
            } catch (error) {
                console.error('Error stopping scanner:', error);
            }
        }
    }
    
    // Start button click handler
    startButton.addEventListener('click', async function() {
        if (isScanning) {
            await stopScanner();
        } else {
            await initScanner();
        }
    });
    
    // Switch camera button
    switchCameraButton.addEventListener('click', async function() {
        // Toggle between front and back cameras
        activeCamera = activeCamera === 'environment' ? 'user' : 'environment';
        showToast(`Beralih ke kamera ${activeCamera === 'environment' ? 'belakang' : 'depan'}`);
        
        // Restart scanner with new camera
        if (isScanning) {
            await stopScanner();
        }
        await initScanner();
    });

    // Barcode detection handler
    Quagga.onDetected(function(result) {
        if (result && result.codeResult && result.codeResult.code) {
            const barcode = result.codeResult.code;
            console.log('Barcode detected:', barcode);
            
            // Pause scanner temporarily
            Quagga.pause();
            
            // Update UI
            resultElement.textContent = barcode;
            scannerStatus.classList.remove('from-blue-500', 'to-indigo-600');
            scannerStatus.classList.add('from-green-500', 'to-emerald-600');
            scannerStatus.querySelector('span').textContent = 'Scan Berhasil!';
            
            // Show success toast
            showToast('Barcode berhasil discan: ' + barcode);
            
            // Check if barcode exists in database
            checkBarcode(barcode).then(response => {
                if (response.exists) {
                    // Product exists, show product info
                    showToast('Produk ditemukan di database!');
                    // Logic to display product information can be added here
                } else {
                    // Product doesn't exist, show add new button
                    addNewProductBtn.classList.remove('hidden');
                    
                    // Remove previous event listeners
                    const newBtn = addNewProductBtn.cloneNode(true);
                    addNewProductBtn.parentNode.replaceChild(newBtn, addNewProductBtn);
                    
                    // Add new event listener
                    newBtn.addEventListener('click', function() {
                        // Reset the form
                        if (productForm) productForm.reset();
                        
                        // Set barcode in form
                        if (productBarcode) productBarcode.value = barcode;
                        
                        // Update modal title
                        if (modalTitle) modalTitle.textContent = 'Tambah Produk Baru';
                        
                        // Show modal
                        if (productModal) productModal.classList.remove('hidden');
                    });
                    
                    // Update reference
                    addNewProductBtn = newBtn;
                }
            });
            
            // Resume scanner after 3 seconds if not adding a product
            setTimeout(() => {
                if (!productModal || productModal.classList.contains('hidden')) {
                    scannerStatus.classList.remove('from-green-500', 'to-emerald-600');
                    scannerStatus.classList.add('from-blue-500', 'to-indigo-600');
                    scannerStatus.querySelector('span').textContent = 'Siap untuk scan';
                    Quagga.resume();
                }
            }, 3000);
        }
    });
    
    // Process error events
    Quagga.onProcessed(function(result) {
        const drawingCtx = Quagga.canvas.ctx.overlay;
        const drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            // Filter out boxes with low confidence
            if (result.boxes && result.boxes.length > 0) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function(box) {
                    return box !== result.box;
                }).forEach(function(box) {
                    Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                });
            }

            // Draw the found barcode box
            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
            }

            // Draw the found barcode line
            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
            }
        }
    });
    
    // Add button to restart scanner when modal is closed
    document.addEventListener('click', function(e) {
        if (e.target && e.target.closest('#cancelProductBtn')) {
            // Resume scanner when modal is closed
            setTimeout(() => {
                scannerStatus.classList.remove('from-green-500', 'to-emerald-600');
                scannerStatus.classList.add('from-blue-500', 'to-indigo-600');
                scannerStatus.querySelector('span').textContent = 'Siap untuk scan';
                addNewProductBtn.classList.add('hidden');
                if (isScanning) {
                    Quagga.resume();
                } else {
                    initScanner();
                }
            }, 500);
        }
    });
    
    // Automatically start scanner after page load with a slight delay
    setTimeout(() => {
        initScanner();
    }, 1000);
    
    // Clean up when page is unloaded
    window.addEventListener('beforeunload', function() {
        stopScanner();
    });
    
    // Add CSS to ensure video takes full width and height
    const style = document.createElement('style');
    style.textContent = `
        #interactive, .video-container {
            position: relative;
            width: 100%;
            height: 100%;
        }
        #interactive canvas, #interactive video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
    `;
    document.head.appendChild(style);
>>>>>>> Stashed changes
});
</script>
@endpush