<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDigital extends Model
{
    protected $table = 'product_digital';
    protected $fillable = ['product_id', 'digital_file'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
} 