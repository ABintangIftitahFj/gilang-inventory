<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_name', 'barcode', 'panjang', 'berat', 'lebar',
        'grade', 'supplier', 'date_received', 'location', 'status', 'notes'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
