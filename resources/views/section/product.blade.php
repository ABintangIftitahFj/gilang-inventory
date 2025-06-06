@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Daftar Produk</h1>
        <button id="openCreateModal" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow font-semibold transition-all duration-300 flex items-center gap-2">
            <i class="fa fa-plus"></i> Tambah Produk
        </button>
    </div>

    <!-- Table & Card Produk -->
    <x-product.table />

    <!-- Modal Create/Edit -->
    <x-product.modal-form />

    <!-- Modal Delete Confirmation -->
    <x-product.modal-delete />
</div>

<!-- Toast Notification -->
<x-product.toast />
@endsection

@push('scripts')
    @vite('resources/js/product.js')
@endpush