<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'price', 'stock', 'image', 'is_hidden', 'type'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function buku()
    {
        return $this->hasOne(ProductBuku::class, 'product_id', 'id');
    }
    public function ebook()
    {
        return $this->hasOne(ProductEbook::class);
    }
    public function ecourse()
    {
        return $this->hasOne(ProductEcourse::class);
    }
    public function digital()
    {
        return $this->hasOne(ProductDigital::class);
    }
}
