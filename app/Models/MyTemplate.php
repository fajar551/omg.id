<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyTemplate extends Model
{
    use HasFactory;

    protected $table = 'my_templates';
    protected $fillable = ['user_id', 'template_id', 'invoice_id'];
}
