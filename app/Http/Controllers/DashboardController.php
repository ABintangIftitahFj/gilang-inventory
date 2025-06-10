<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard dengan data dari database
     */
    public function index()
    {
        // Hitung total semua item 
        $totalItem = Product::count();

        // Hitung total jenis produk (unique by name case-insensitive)
        $totalJenisProduk = Product::select(DB::raw('COUNT(DISTINCT LOWER(product_name)) as count'))
            ->first()
            ->count;

        // Hitung persentase perubahan stok bulan ini vs bulan lalu
        $produkBulanIni = Product::whereMonth('created_at', now()->month)
            ->count();
            
        $produkBulanLalu = Product::whereMonth('created_at', now()->subMonth()->month)
            ->count();

        // Hitung persentase perubahan
        $persentasePerubahan = $produkBulanLalu > 0
            ? round((($produkBulanIni - $produkBulanLalu) / $produkBulanLalu) * 100)
            : 0;

        // Hitung transaksi masuk hari ini
        $transaksiMasukHariIni = Transaction::where('transaction_type', 'IN')
            ->whereDate('created_at', today())
            ->count();

        // Hitung transaksi masuk kemarin untuk perbandingan
        $transaksiMasukKemarin = Transaction::where('transaction_type', 'IN')
            ->whereDate('created_at', today()->subDay())
            ->count();

        // Selisih transaksi masuk hari ini dengan kemarin
        $selisihMasuk = $transaksiMasukHariIni - $transaksiMasukKemarin;

        // Hitung transaksi keluar hari ini
        $transaksiKeluarHariIni = Transaction::where('transaction_type', 'OUT')
            ->whereDate('created_at', today())
            ->count();

        // Hitung transaksi keluar kemarin untuk perbandingan
        $transaksiKeluarKemarin = Transaction::where('transaction_type', 'OUT')
            ->whereDate('created_at', today()->subDay())
            ->count();

        // Selisih transaksi keluar hari ini dengan kemarin
        $selisihKeluar = $transaksiKeluarHariIni - $transaksiKeluarKemarin;

        // Ambil 5 transaksi terakhir
        $transaksiTerakhir = Transaction::with('product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Hitung total transaksi untuk paging info
        $totalTransaksi = Transaction::count();

        return view('dashboard', compact(
            'totalItem',
            'totalJenisProduk',
            'transaksiMasukHariIni',
            'selisihMasuk',
            'transaksiKeluarHariIni',
            'selisihKeluar',
            'transaksiTerakhir',
            'totalTransaksi',
            'persentasePerubahan'
        ));
    }
}
