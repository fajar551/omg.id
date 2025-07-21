<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'features';
    protected $fillable = ['title', 'feature', 'description'];

}
