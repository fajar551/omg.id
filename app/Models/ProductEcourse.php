<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEcourse extends Model
{
    protected $table = 'product_ecourse';
    protected $fillable = ['product_id', 'ecourse_url', 'ecourse_duration'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
} 