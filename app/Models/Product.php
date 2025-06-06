<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name', 'barcode', 'panjang', 'berat', 'lebar',
        'grade', 'supplier', 'date_received', 'location', 'status', 'notes'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
