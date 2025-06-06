@extends('layouts.admin')

@section('content')
<div class="bg-white shadow-md rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Pengaturan Sistem</h2>
        <p class="text-sm text-gray-500 mt-1">Konfigurasi sistem inventory</p>
    </div>

    <div class="p-6">
        <!-- Tabs -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">
                    Umum
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Notifikasi
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Keamanan
                </button>
                <button class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    Cadangan & Pemulihan
                </button>
            </nav>
        </div>

        <!-- General Settings Form -->
        <form class="mt-6">
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Detail Perusahaan</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Informasi ini akan ditampilkan pada laporan dan dokumen yang dicetak.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="company_name" class="block text-sm font-medium text-gray-700">
                            Nama Perusahaan
                        </label>
                        <div class="mt-1">
                            <input type="text" name="company_name" id="company_name" value="Gilang Inventory" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="company_address" class="block text-sm font-medium text-gray-700">
                            Alamat
                        </label>
                        <div class="mt-1">
                            <textarea id="company_address" name="company_address" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">Jl. Inventory No. 123, Jakarta Selatan</textarea>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="company_phone" class="block text-sm font-medium text-gray-700">
                            No. Telepon
                        </label>
                        <div class="mt-1">
                            <input type="text" name="company_phone" id="company_phone" value="021-1234567" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="company_email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <div class="mt-1">
                            <input type="email" name="company_email" id="company_email" value="info@gilang-inventory.com" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <hr class="my-8 border-gray-200">

        <!-- System Settings -->
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">Pengaturan Sistem</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Konfigurasi dasar untuk sistem inventory.
                </p>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Notifikasi Stok Menipis</h4>
                        <p class="text-sm text-gray-500">Dapatkan notifikasi saat stok barang hampir habis</p>
                    </div>
                    <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-indigo-600" role="switch" aria-checked="true">
                        <span class="sr-only">Use setting</span>
                        <span aria-hidden="true" class="translate-x-5 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                    </button>
                </div>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">Laporan Otomatis</h4>
                        <p class="text-sm text-gray-500">Kirim laporan mingguan via email</p>
                    </div>
                    <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-gray-200" role="switch" aria-checked="false">
                        <span class="sr-only">Use setting</span>
                        <span aria-hidden="true" class="translate-x-0 pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                    </button>
                </div>

                <div>
                    <label for="low_stock_threshold" class="block text-sm font-medium text-gray-700">
                        Ambang Batas Stok Menipis
                    </label>
                    <div class="mt-1">
                        <input type="number" name="low_stock_threshold" id="low_stock_threshold" value="10" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Produk akan ditandai sebagai "stok menipis" saat jumlahnya mencapai nilai ini</p>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Atur Ulang
                    </button>
                    <button type="button" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
