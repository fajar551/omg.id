<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pages_categories';
    protected $fillable = ['title'];

    public function pages()
    {
        return $this->hasMany(Page::class, 'category_id', 'id');
    }
}
