// resources/js/scanner.js

import { BrowserMultiFormatReader, NotFoundException } from '@zxing/library';

document.addEventListener('DOMContentLoaded', () => {
    const codeReader = new BrowserMultiFormatReader();
    const videoElement = document.getElementById('video');
    const resultElement = document.getElementById('result');
    const startScanButton = document.getElementById('startScanButton');
    const stopScanButton = document.getElementById('stopScanButton');
    const switchCameraButton = document.getElementById('switchCameraButton');

    let selectedDeviceId;
    let videoInputDevices = [];
    let lastScannedBarcode = null;
    let scanCooldownTimeout = null;
    const SCAN_COOLDOWN_MS = 3000;

    console.log('ZXing code reader initialized');

    // Fungsi untuk mendapatkan daftar kamera dan memilih yang pertama kali
    const getDevicesAndSelectFirst = async () => {
        try {
            videoInputDevices = await codeReader.listVideoInputDevices();
            if (videoInputDevices.length > 0) {
                const rearCamera = videoInputDevices.find(device =>
                    device.label.toLowerCase().includes('back') ||
                    device.label.toLowerCase().includes('belakang') ||
                    device.label.toLowerCase().includes('rear')
                );
                selectedDeviceId = rearCamera ? rearCamera.deviceId : videoInputDevices[0].deviceId;
                console.log('Initial camera selected:', selectedDeviceId);

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
            console.error('Error listing devices:', err);
            resultElement.textContent = `Error listing devices: ${err}`;
        }
    };

    // Fungsi untuk mengirim barcode ke backend (API Laravel)
    const checkBarcodeInDatabase = async (barcode) => {
        try {
            // Ubah URL API di sini untuk mengarah ke rute 'check-barcode'
            const response = await fetch('/api/check-barcode', { // <--- UBAH URL INI
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ barcode: barcode })
            });

            const data = await response.json();

            if (data.success) {
                if (data.status === 'exists') {
                    resultElement.textContent = `Barcode ${barcode}: SUDAH ADA di database.`;
                    resultElement.style.color = 'green';
                    console.log('Product data:', data.data);
                    // Anda bisa menambahkan logika lebih lanjut di sini,
                    // misalnya menampilkan detail produk di UI
                } else { // data.status === 'not_exists'
                    resultElement.textContent = `Barcode ${barcode}: BELUM ADA di database.`;
                    resultElement.style.color = 'red';
                }
            } else {
                resultElement.textContent = `Error checking barcode: ${data.message || 'Unknown error'}`;
                resultElement.style.color = 'orange';
                console.error('API Error:', data.errors || data.message);
            }
        } catch (error) {
            resultElement.textContent = `Network error: ${error.message}`;
            resultElement.style.color = 'orange';
            console.error('Fetch error:', error);
        }
    };

    // Fungsi untuk memulai scanning
    const startScanning = () => {
        if (!selectedDeviceId) {
            resultElement.textContent = 'Please wait, detecting cameras...';
            console.warn('No camera selected yet. Please try again.');
            getDevicesAndSelectFirst().then(() => {
                if (selectedDeviceId) startScanning();
            });
            return;
        }

        resultElement.textContent = 'Scanning...';
        resultElement.style.color = '';
        codeReader.decodeFromVideoDevice(selectedDeviceId, videoElement, (result, err) => {
            if (result) {
                const currentBarcode = result.getText();
                if (currentBarcode !== lastScannedBarcode || !scanCooldownTimeout) {
                    console.log('Barcode found:', currentBarcode);
                    lastScannedBarcode = currentBarcode;

                    if (scanCooldownTimeout) {
                        clearTimeout(scanCooldownTimeout);
                    }
                    scanCooldownTimeout = setTimeout(() => {
                        lastScannedBarcode = null;
                        scanCooldownTimeout = null;
                        resultElement.textContent = 'Scanning...';
                        resultElement.style.color = '';
                    }, SCAN_COOLDOWN_MS);

                    checkBarcodeInDatabase(currentBarcode);
                }
            }
            if (err && !(err instanceof NotFoundException)) {
                console.error(err);
                resultElement.textContent = `Error: ${err}`;
                resultElement.style.color = 'red';
            }
        });

        console.log(`Started decoding from deviceId: ${selectedDeviceId}`);
        if (startScanButton) startScanButton.style.display = 'none';
        if (stopScanButton) stopScanButton.style.display = 'inline-block';
        if (switchCameraButton && videoInputDevices.length > 1) switchCameraButton.style.display = 'inline-block';
    };

    // Fungsi untuk menghentikan scanning
    const stopScanning = () => {
        codeReader.reset();
        resultElement.textContent = 'Scanning stopped.';
        resultElement.style.color = '';
        console.log('Scanning stopped.');
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
            stopScanning();

            const currentIndex = videoInputDevices.findIndex(device => device.deviceId === selectedDeviceId);
            const nextIndex = (currentIndex + 1) % videoInputDevices.length;
            selectedDeviceId = videoInputDevices[nextIndex].deviceId;

            console.log('Switching to camera:', videoInputDevices[nextIndex].label);
            startScanning();
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

    window.addEventListener('beforeunload', () => {
        stopScanning();
    });
});