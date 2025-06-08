{{-- resources/views/scan.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Barcode Scanner</h1>

    <div class="card p-4 shadow-sm">
        <div class="card-body text-center">
            <video id="video" width="100%" height="auto" style="max-width: 600px; display: block; margin: 0 auto; border: 1px solid #ddd;"></video>
            <div id="result" class="mt-4 fs-5 fw-bold text-primary">Detecting cameras...</div>

            <div class="mt-4 d-flex justify-content-center gap-2">
                <button id="startScanButton" class="btn btn-success px-4">Start Scan</button>
                <button id="stopScanButton" class="btn btn-danger px-4" style="display: none;">Stop Scan</button>
                <button id="switchCameraButton" class="btn btn-secondary px-4" style="display: none;">Switch Camera</button>
            </div>
        </div>
    </div>
</div>

{{-- Include Product Form Modal --}}
<x-product.modal-form />
@endsection

@push('scripts')
    @vite('resources/js/scanner.js')
    @vite('resources/js/product.js')
@endpush