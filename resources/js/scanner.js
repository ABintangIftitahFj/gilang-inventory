// resources/js/scanner.js

import { BrowserMultiFormatReader, NotFoundException, BarcodeFormat, DecodeHintType } from '@zxing/library';

document.addEventListener('DOMContentLoaded', () => {
    // Define hints for the barcode reader
    const hints = new Map();
    const formats = [
        BarcodeFormat.QR_CODE,
        BarcodeFormat.EAN_13,
        BarcodeFormat.EAN_8,
        BarcodeFormat.CODE_128,
        BarcodeFormat.CODE_39,
        BarcodeFormat.UPC_A,
        BarcodeFormat.UPC_E,
        BarcodeFormat.ITF,
        BarcodeFormat.DATA_MATRIX,
        BarcodeFormat.AZTEC,
        BarcodeFormat.PDF_417,
        BarcodeFormat.CODABAR
    ];
    hints.set(DecodeHintType.POSSIBLE_FORMATS, formats);
    hints.set(DecodeHintType.TRY_HARDER, true);
    hints.set(DecodeHintType.ASSUME_GS1, false);
    // Improved barcode detection
    hints.set(DecodeHintType.CHARACTER_SET, 'UTF-8');

    const codeReader = new BrowserMultiFormatReader(hints);

    const videoElement = document.getElementById('video');
    const videoContainer = document.getElementById('video-container');
    const resultElement = document.getElementById('result');
    const startScanButton = document.getElementById('startScanButton');
    const stopScanButton = document.getElementById('stopScanButton');
    const switchCameraButton = document.getElementById('switchCameraButton');

    // Product Modal Elements (assuming IDs from modal-form.blade.php)
    const productModal = document.getElementById('productModal');
    const productForm = document.getElementById('productForm');
    const productBarcodeField = document.getElementById('productBarcode');
    const productNameField = document.getElementById('productName'); // Assuming you want to focus this
    const closeProductModalButton = document.getElementById('closeProductModal');
    const cancelProductBtn = document.getElementById('cancelProductBtn');
    const modalTitle = document.getElementById('modalTitle');

    let selectedDeviceId;
    let videoInputDevices = [];
    let lastScannedBarcode = null;
    let scanCooldownTimeout = null;
    const SCAN_COOLDOWN_MS = 1500; // 1.5 seconds cooldown - reduced from 3 seconds for better responsiveness

    console.log('ZXing code reader initialized');

    const showNotification = (message, type = 'success') => {
        // Simple notification, replace with a more robust library if needed
        const notification = document.createElement('div');
        notification.textContent = message;
        notification.style.position = 'fixed';
        notification.style.top = '20px';
        notification.style.right = '20px';
        notification.style.padding = '10px 20px';
        notification.style.borderRadius = '5px';
        notification.style.color = 'white';
        notification.style.zIndex = '1000';
        notification.style.backgroundColor = type === 'success' ? 'green' : (type === 'error' ? 'red' : 'blue');
        document.body.appendChild(notification);
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 3000);
    };

    const openProductModal = (barcodeToFill = '') => {
        if (productModal) {
            modalTitle.textContent = 'Tambah Produk Baru (Barcode: ' + barcodeToFill + ')';
            productForm.reset(); // Reset form for new entry
            document.getElementById('productId').value = ''; // Clear product ID for new entry
            if (productBarcodeField) {
                productBarcodeField.value = barcodeToFill;
            }
            productModal.classList.remove('hidden');
            if (productNameField) {
                productNameField.focus(); // Focus on product name or first relevant field
            }
        }
    };

    const closeProductModal = () => {
        if (productModal) {
            productModal.classList.add('hidden');
        }
    };

    if (closeProductModalButton) {
        closeProductModalButton.addEventListener('click', closeProductModal);
    }
    if (cancelProductBtn) {
        cancelProductBtn.addEventListener('click', closeProductModal);
    }
    // Close modal on ESC key
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !productModal.classList.contains('hidden')) {
            closeProductModal();
        }
    });


    // Fungsi untuk mendapatkan daftar kamera dan memilih yang pertama kali
    const getDevicesAndSelectFirst = async () => {
        try {
            videoInputDevices = await codeReader.listVideoInputDevices();
            console.log('Video input devices found:', videoInputDevices);
            if (videoInputDevices.length > 0) {
                const rearCamera = videoInputDevices.find(device =>
                    device.label.toLowerCase().includes('back') ||
                    device.label.toLowerCase().includes('belakang') ||
                    device.label.toLowerCase().includes('rear')
                );
                selectedDeviceId = rearCamera ? rearCamera.deviceId : videoInputDevices[0].deviceId;
                console.log('Initial camera selected ID:', selectedDeviceId, 'Label:', videoInputDevices.find(d => d.deviceId === selectedDeviceId)?.label);

                if (videoInputDevices.length > 1) {
                    if (switchCameraButton) switchCameraButton.style.display = 'inline-block';
                } else {
                    if (switchCameraButton) switchCameraButton.style.display = 'none';
                }
            } else {
                resultElement.textContent = 'No video input devices found.';
                console.error('No video input devices found.');
                if (startScanButton) startScanButton.style.display = 'none';
                if (stopScanButton) stopScanButton.style.display = 'none';
                if (switchCameraButton) switchCameraButton.style.display = 'none';
            }
        } catch (err) {
            console.error('Error listing video devices:', err);
            if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                resultElement.textContent = 'Camera permission denied. Please allow access to the camera.';
                showNotification('Camera permission denied. Please allow access to the camera.', 'error');
            } else {
                resultElement.textContent = `Error listing devices: ${err.message}`;
            }
        }
    };

    // Fungsi untuk mengirim barcode ke backend (API Laravel)
    const checkBarcodeInDatabase = async (barcode) => {
        try {
            const baseUrl = window.location.origin;
            console.log(`Sending request to: ${baseUrl}/api/v1/barcode/check`);
            const response = await fetch(`${baseUrl}/api/v1/barcode/check`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ barcode: barcode })
            });

            const data = await response.json();
            resultElement.style.transition = 'all 0.1s ease-in-out';
            resultElement.style.fontWeight = 'bold';

            if (response.ok && data.success) {
                showNotification(`Barcode ${barcode} scanned successfully!`, 'success');
                if (data.status === 'exists') {
                    resultElement.textContent = `Barcode: ${barcode} - ${data.message} Product: ${data.data.product_name}`;
                    resultElement.style.color = 'green';
                    resultElement.style.transform = 'scale(1.05)';
                } else if (data.status === 'not_exists') {
                    resultElement.textContent = `Barcode: ${barcode} - ${data.message}`;
                    resultElement.style.color = 'darkorange';
                    resultElement.style.transform = 'scale(1.05)';
                    openProductModal(barcode); // Open modal to add new product
                } else {
                    resultElement.textContent = `Barcode: ${barcode} - ${data.message || 'Unknown success status.'}`;
                    resultElement.style.color = 'dodgerblue';
                    resultElement.style.transform = 'scale(1.05)';
                }
            } else {
                const errorMessage = data.message || (data.errors ? Object.values(data.errors).join(', ') : `Error: ${response.statusText}`);
                resultElement.textContent = `Error checking barcode ${barcode}: ${errorMessage}`;
                resultElement.style.color = 'red';
                resultElement.style.transform = 'scale(1.05)';
                showNotification(`Error checking barcode ${barcode}: ${errorMessage}`, 'error');
            }

            setTimeout(() => {
                resultElement.style.transform = 'scale(1)';
            }, 500);

        } catch (error) {
            console.error('Error checking barcode:', error);
            resultElement.textContent = `Network or parsing error for barcode ${barcode}: ${error.message}`;
            resultElement.style.color = 'red';
            resultElement.style.transform = 'scale(1.05)';
            showNotification(`Network error for barcode ${barcode}: ${error.message}`, 'error');
            setTimeout(() => {
                resultElement.style.transform = 'scale(1)';
            }, 500);
        }
    };

    // Helper function to set optimal camera constraints
    const getVideoConstraints = (deviceId) => {
        return {
            deviceId: { exact: deviceId },
            width: { ideal: 1280 },
            height: { ideal: 720 },
            aspectRatio: { ideal: 1.777777778 },
            facingMode: { ideal: "environment" }
        };
    };
    
    // Fungsi untuk memulai scanning
    const startScanning = async () => {
        if (!selectedDeviceId) {
            resultElement.textContent = 'No camera selected. Please wait or check permissions.';
            await getDevicesAndSelectFirst();
            if (selectedDeviceId) {
                startScanning();
            }
            return;
        }

        // Always reset before starting a new scan to avoid conflicts
        codeReader.reset();

        resultElement.textContent = 'Scanning... Please center the barcode in view';
        resultElement.style.color = '';

        // Set debug message
        console.log('Starting barcode scanner with device ID:', selectedDeviceId);
        showNotification('Mulai memindai barcode...', 'info');

        // Always show scan-line effect while scanning
        if (videoContainer) {
            videoContainer.classList.add('scan-line-active');
        }
        
        // Request focus on mobile devices
        setTimeout(() => {
            if (videoElement && typeof videoElement.focus === 'function') {
                videoElement.focus();
            }
        }, 1000);

        // Start decoding (ZXing will handle video stream)
        hints.set(DecodeHintType.TRY_HARDER, true);
        hints.set(DecodeHintType.PURE_BARCODE, true);
        
        // Get customized video constraints
        const constraints = getVideoConstraints(selectedDeviceId);
        
        try {
            // Play a beep sound when barcode is detected
            const beepSound = new Audio('data:audio/mp3;base64,SUQzBAAAAAAAI1RTU0UAAAAPAAADTGF2ZjU4LjIwLjEwMAAAAAAAAAAAAAAA//tQwAAAAAAAAAAAAAAAAAAAAAAASW5mbwAAAA8AAAAeAAAkIAAVFRUVISEhISoqKio2NjY2QkJCQk1NTU1YWFhYZGRkZG9vb290dHR0f39/f4uLi4uWlpaWoaGhoaysrKy4uLi4w8PDw87Ozs7Z2dna5eXl5fDw8PD7+/v7//////////8AAAAATGF2YzU4LjM1AAAAAAAAAAAAAAAAJAAAAAAAAAAAJCDWQsqxAAAAAAAAAAAAAAAAAAAA//tAxAAABoSLu9SYABG1JmB59iAA4sBAwHAYFP38QBBoGAgAj5/H4fAQEB/gg/B+D8Hg/iD4Pn/B+IAYDgfggGAYCAIAgCDnwff+CAYBgfBAMBwEBz+IAQBB/BAEAQdBAEAQcEAIAgCDggBAEAQdBACAYP4IAgCAYOCAIAg58EH4PwQdB+D8H8QBAMHBACDg/h+IPoIBgGD+IAg/iAIOD8EHQf/8QdBAEHPgIBgPB+D+IOD4PvggCAYP4g4Pw+CAYBgGD+IAg6CAIOCAYBgGD//+IOgg/ggGD+D//g/B9//HwQD/8='
            );
            beepSound.volume = 0.5; // Set volume to 50%
            
            codeReader.decodeFromConstraints(
                { video: constraints },
                videoElement, 
                (result, err) => {
                    if (result) {
                        const currentBarcode = result.getText();
                        console.log("Barcode detected:", currentBarcode);
                        
                        // Flash feedback and play sound
                        if (videoContainer) {
                            videoContainer.style.border = '3px solid green';
                            videoContainer.style.boxShadow = '0 0 15px rgba(0, 255, 0, 0.7)';
                            setTimeout(() => {
                                videoContainer.style.border = '1px solid gray';
                                videoContainer.style.boxShadow = 'none';
                            }, 500);
                        }
                        
                        try {
                            beepSound.play();
                        } catch (audioErr) {
                            console.log('Audio error:', audioErr);
                        }
                        
                        if (currentBarcode !== lastScannedBarcode || !scanCooldownTimeout) {
                            lastScannedBarcode = currentBarcode;
                            resultElement.textContent = `Reading barcode: ${currentBarcode}...`;
                            resultElement.style.color = 'blue';
                            checkBarcodeInDatabase(currentBarcode);
                            scanCooldownTimeout = setTimeout(() => {
                                lastScannedBarcode = null;
                                scanCooldownTimeout = null;
                                if (!productModal || productModal.classList.contains('hidden')) {
                                    resultElement.textContent = 'Scanning... Please center the barcode in view';
                                    resultElement.style.color = '';
                                }
                            }, SCAN_COOLDOWN_MS);
                        }
                    }
                if (err && !(err instanceof NotFoundException)) {
                    console.error("Scanner error:", err);
                    resultElement.textContent = `Scan Error: ${err.message}`;
                    resultElement.style.color = 'red';
                    // Don't remove scan-line here, only on stop
                }
            });
            
            // Add debug logs for successful camera start
            console.log('Camera started successfully');
            
            // Try to improve camera on mobile
            if (videoElement) {
                videoElement.onloadedmetadata = () => {
                    console.log('Video dimensions:', videoElement.videoWidth, 'x', videoElement.videoHeight);
                };
                
                // Add tap to focus functionality for mobile devices
                videoElement.addEventListener('click', function() {
                    if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
                        const videoTrack = videoElement.srcObject?.getVideoTracks()[0];
                        if (videoTrack && typeof videoTrack.getCapabilities === 'function') {
                            const capabilities = videoTrack.getCapabilities();
                            // Check if the camera supports focus mode
                            if (capabilities.focusMode && capabilities.focusMode.includes('manual')) {
                                videoTrack.applyConstraints({ advanced: [{ focusMode: 'manual', focusDistance: 0.05 }] })
                                    .catch(e => console.log('Focus error:', e));
                            }
                        }
                    }
                    showNotification('Focusing camera...', 'info');
                });
            }
            
        } catch (err) {
            console.error('Camera access error:', err);
            resultElement.textContent = 'Failed to access camera: ' + err.message;
            resultElement.style.color = 'red';
            showNotification('Failed to access camera. Please check permissions and try again.', 'error');
            if (videoContainer) videoContainer.classList.remove('scan-line-active');
            return;
        }
        if (startScanButton) startScanButton.style.display = 'none';
        if (stopScanButton) stopScanButton.style.display = 'inline-block';
        if (switchCameraButton && videoInputDevices.length > 1) switchCameraButton.style.display = 'inline-block';
    };

    // Fungsi untuk menghentikan scanning
    const stopScanning = () => {
        codeReader.reset();
        if (videoContainer) {
            videoContainer.classList.remove('scan-line-active');
        }
        if (!productModal || productModal.classList.contains('hidden')) {
            resultElement.textContent = 'Scanning stopped.';
            resultElement.style.color = '';
        }
        lastScannedBarcode = null;
        if (scanCooldownTimeout) {
            clearTimeout(scanCooldownTimeout);
            scanCooldownTimeout = null;
        }
        if (startScanButton) startScanButton.style.display = 'inline-block';
        if (stopScanButton) stopScanButton.style.display = 'none';
        if (switchCameraButton) switchCameraButton.style.display = 'none';
    };

    // Fungsi untuk mengganti kamera
    const switchCamera = () => {
        if (videoInputDevices.length > 1) {
            stopScanning(); // Stop current stream before switching

            const currentIndex = videoInputDevices.findIndex(device => device.deviceId === selectedDeviceId);
            const nextIndex = (currentIndex + 1) % videoInputDevices.length;
            selectedDeviceId = videoInputDevices[nextIndex].deviceId;

            console.log('Switching to camera:', videoInputDevices[nextIndex].label);
            // Brief delay to ensure camera resource is released and re-acquired smoothly
            setTimeout(() => {
                startScanning();
            }, 100); // 100ms delay, adjust if needed
        } else {
            console.log('Only one camera available.');
        }
    };

    // Event listener untuk tombol start dan stop
    if (startScanButton) {
        startScanButton.addEventListener('click', startScanning);
    }
    if (stopScanButton) {
        stopScanButton.addEventListener('click', stopScanning);
    }
    if (switchCameraButton) {
        switchCameraButton.addEventListener('click', switchCamera);
    }

    getDevicesAndSelectFirst();

    // Stop scanning when the page is about to be unloaded
    window.addEventListener('beforeunload', () => {
        stopScanning();
    });
});