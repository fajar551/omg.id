<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model
{
    use HasFactory;

    protected $table = 'pages_templates';
    protected  $fillable = ['title', 'image', 'category', 'price', 'directory_name'];
}
