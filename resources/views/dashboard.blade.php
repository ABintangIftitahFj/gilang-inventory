@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard</h1>

    <!-- Ringkasan Stok -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-600 text-sm">Total Produk</h2>
            <p class="text-2xl font-bold text-blue-600">120</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-600 text-sm">Tersedia</h2>
            <p class="text-2xl font-bold text-green-600">95</p>
        </div>
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-gray-600 text-sm">Habis</h2>
            <p class="text-2xl font-bold text-red-600">25</p>
        </div>
    </div>

    <!-- Tombol Aksi Cepat -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Aksi Cepat</h2>
        <div class="flex gap-4">
            <a href="#" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded shadow">📷 Scan Barcode</a>
            <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">Tambah Produk Baru</a>
        </div>
    </div>

    <!-- Statistik Pergerakan Stok -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Statistik Hari Ini</h2>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-gray-600 text-sm">Transaksi Masuk (IN)</h3>
                <p class="text-xl font-bold text-blue-500">15</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <h3 class="text-gray-600 text-sm">Transaksi Keluar (OUT)</h3>
                <p class="text-xl font-bold text-pink-500">8</p>
            </div>
        </div>
    </div>

    <!-- 10 Transaksi Terakhir -->
    <div>
        <h2 class="text-lg font-semibold text-gray-700 mb-4">10 Transaksi Terakhir</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded-lg">
                <thead>
                    <tr class="bg-gray-200 text-left text-sm text-gray-600">
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Produk</th>
                        <th class="px-4 py-2">Jenis</th>
                        <th class="px-4 py-2">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    <tr>
                        <td class="px-4 py-2">2025-06-04</td>
                        <td class="px-4 py-2">Pulpen Gel</td>
                        <td class="px-4 py-2 text-green-600">IN</td>
                        <td class="px-4 py-2">50</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">2025-06-03</td>
                        <td class="px-4 py-2">Kertas A4</td>
                        <td class="px-4 py-2 text-red-600">OUT</td>
                        <td class="px-4 py-2">20</td>
                    </tr>
                    <!-- Tambah 8 data dummy lainnya sesuai kebutuhan -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
