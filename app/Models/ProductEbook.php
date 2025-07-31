<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEbook extends Model
{
    protected $table = 'product_ebook';
    protected $fillable = ['product_id', 'ebook_file', 'ebook_pages'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
} 