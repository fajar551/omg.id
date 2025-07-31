<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model {
    use HasFactory;

    protected $fillable = [
        'product_id', 'buyer_name', 'buyer_email', 'status'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
