<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'product_name' => 'Kain Katun',
            'barcode' => '1234567890123',
            'panjang' => 50.00,
            'berat' => 10.00,
            'lebar' => 100.00,
            'grade' => 'A',
            'supplier' => 'Supplier A',
            'date_received' => '2025-06-01',
            'location' => 'Gudang A',
            'status' => 'in_stock',
            'notes' => 'Produk baru masuk',
        ]);

        // Tambah 9-14 data lain sesuai kebutuhan
    }
}
