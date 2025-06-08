{{-- resources/views/scan.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Barcode Scanner</h1>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <!-- Video container for scan line effect -->
        <div id="video-container" class="mb-4 video-container">
            <video id="video" playsinline autoplay></video> <!-- Added autoplay for faster startup -->
            <div class="scan-instructions">
                Arahkan barcode di tengah kotak putus-putus
            </div>
        </div>

        <div class="mb-6">
            <button id="startScanButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                Start Scan
            </button>
            <button id="stopScanButton" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" style="display:none;">
                Stop Scan
            </button>
            <button id="switchCameraButton" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2" type="button" style="display:none;">
                Switch Camera
            </button>
            
            <a href="{{ route('camera.test') }}" target="_blank" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">
                Test Camera
            </a>
        </div>
        
        <div class="mb-3 text-sm text-gray-600">
            <p>Tips: Arahkan barcode ke tengah kotak putus-putus, jaga jarak 10-20cm dengan pencahayaan yang baik.</p>
        </div>

        <div id="result" class="text-lg font-semibold mb-4 p-3 rounded-md" style="min-height: 50px; border: 1px solid #eee; background-color: #f8f9fa;">
            Scan result will appear here...
        </div>

        <!-- Product Modal Component -->
        <x-product.modal-form />
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/scanner.js'])
@endpush

<style>
    /* Styles for video container and scanning line animation */
    .video-container {
        position: relative;
        overflow: hidden; /* Ensures the pseudo-element respects boundaries */
        border: 1px solid gray; /* Keep existing border if desired */
        background-color: #000; /* Optional: background for when camera not active */
        max-width: 640px; /* Limit maximum width */
        margin: 0 auto; /* Center the container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px; /* Rounded corners */
    }

    #video {
        display: block; /* Removes extra space below video element */
        width: 100%;
        height: auto;
        max-height: 480px; /* Limit maximum height */
        object-fit: cover; /* Ensure the video fills the container */
    }
    
    /* Add a targeting reticle/crosshair to help users center the barcode */
    .video-container::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        height: 100px;
        transform: translate(-50%, -50%);
        border: 2px dashed rgba(255, 255, 255, 0.7);
        border-radius: 10px;
        pointer-events: none;
        z-index: 5;
    }

    .video-container.scan-line-active::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px; /* Increased thickness of the scan line */
        background: linear-gradient(90deg, transparent, rgba(255, 0, 0, 0.9), transparent); 
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.9); /* Stronger glow effect */
        animation: scanning-line 1.5s infinite ease-in-out;
        z-index: 10; /* Ensure it's above the video */
        pointer-events: none; /* Ensure the line doesn't interfere with clicks */
    }

    /* Instructions overlay to help users */
    .scan-instructions {
        position: absolute;
        bottom: 10px;
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 5px;
        font-size: 12px;
        text-align: center;
        z-index: 15;
    }

    @keyframes scanning-line {
        0% {
            transform: translateY(0);
            opacity: 0.8; 
        }
        50% {
            transform: translateY(calc(100% - 5px)); 
            opacity: 1.0; 
        }
        100% {
            transform: translateY(0);
            opacity: 0.8; 
        }
    }
    
    /* Brightness increase for video to help with barcode scanning */
    #video {
        filter: brightness(1.2) contrast(1.1);
    }
</style>