<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('barcode')->unique();
            $table->decimal('panjang', 8, 2);
            $table->decimal('berat', 8, 2);
            $table->decimal('lebar', 8, 2);
            $table->string('grade');
            $table->string('supplier');
            $table->date('date_received');
            $table->string('location');
            $table->enum('status', ['in_stock', 'out_of_stock']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
