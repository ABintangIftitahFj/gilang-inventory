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

        Product::create([
            'product_name' => 'Kain Sutra',
            'barcode' => '1234567890124',
            'panjang' => 40.00,
            'berat' => 8.00,
            'lebar' => 90.00,
            'grade' => 'B',
            'supplier' => 'Supplier B',
            'date_received' => '2025-06-02',
            'location' => 'Gudang B',
            'status' => 'in_stock',
            'notes' => 'Stok lama',
        ]);

        Product::create([
            'product_name' => 'Kain Linen',
            'barcode' => '1234567890125',
            'panjang' => 60.00,
            'berat' => 12.00,
            'lebar' => 110.00,
            'grade' => 'A',
            'supplier' => 'Supplier C',
            'date_received' => '2025-06-03',
            'location' => 'Gudang C',
            'status' => 'in_stock',
            'notes' => 'Kualitas premium',
        ]);

        Product::create([
            'product_name' => 'Kain Rayon',
            'barcode' => '1234567890126',
            'panjang' => 55.00,
            'berat' => 9.00,
            'lebar' => 105.00,
            'grade' => 'C',
            'supplier' => 'Supplier D',
            'date_received' => '2025-06-04',
            'location' => 'Gudang D',
            'status' => 'out_of_stock',
            'notes' => 'Akan restock',
        ]);

        Product::create([
            'product_name' => 'Kain Denim',
            'barcode' => '1234567890127',
            'panjang' => 70.00,
            'berat' => 15.00,
            'lebar' => 120.00,
            'grade' => 'B',
            'supplier' => 'Supplier E',
            'date_received' => '2025-06-05',
            'location' => 'Gudang E',
            'status' => 'in_stock',
            'notes' => 'Stok terbatas',
        ]);
    }
}
