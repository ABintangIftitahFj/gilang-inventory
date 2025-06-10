@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-7xl">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-4 mb-4 sm:mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Daftar Produk</h1>
        <button id="openCreateModal" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 sm:px-5 py-1.5 sm:py-2 rounded-lg sm:rounded-xl shadow font-medium sm:font-semibold transition-all duration-300 flex items-center gap-1 sm:gap-2 text-sm sm:text-base">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk
        </button>
    </div>

    <!-- Table & Card Produk -->
    <x-product.table :products="$products" />

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