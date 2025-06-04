<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transactions')->insert([
            [
                'product_id' => 1,
                'barcode' => '1234567890123',
                'transaction_type' => 'in',
                'quantity' => 10,
                'user_name' => 'Alice',
                'notes' => 'Initial stock',
            ],
            [
                'product_id' => 2,
                'barcode' => '2345678901234',
                'transaction_type' => 'out',
                'quantity' => 5,
                'user_name' => 'Bob',
                'notes' => 'Sold to customer',
            ],
            [
                'product_id' => 3,
                'barcode' => '3456789012345',
                'transaction_type' => 'in',
                'quantity' => 20,
                'user_name' => 'Charlie',
                'notes' => 'Restock',
            ],
            [
                'product_id' => 4,
                'barcode' => '4567890123456',
                'transaction_type' => 'out',
                'quantity' => 2,
                'user_name' => 'Diana',
                'notes' => 'Damaged goods',
            ],
            [
                'product_id' => 5,
                'barcode' => '5678901234567',
                'transaction_type' => 'in',
                'quantity' => 15,
                'user_name' => 'Eve',
                'notes' => 'Supplier delivery',
            ],
        ]);
    }
}
