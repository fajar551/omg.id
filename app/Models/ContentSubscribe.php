<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSubscribe extends Model
{
    use HasFactory;

    protected $table = 'content_subscribes';
    protected $fillable = ['user_id', 'content_id', 'start', 'end', 'status'];


    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
