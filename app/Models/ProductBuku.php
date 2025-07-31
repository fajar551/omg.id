<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBuku extends Model
{
    protected $table = 'product_buku';
    protected $fillable = ['product_id', 'city'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
} 