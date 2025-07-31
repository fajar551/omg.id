<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'buyer_name',
        'buyer_email',
        'buyer_address',
        'buyer_message',
        'quantity',
        'total_price',
        'status',
        'order_id',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
} 