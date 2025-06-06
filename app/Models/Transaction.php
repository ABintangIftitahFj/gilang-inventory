<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'barcode', 'transaction_type', 'quantity', 'user_name', 'notes'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
