<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $dates = ['scheduled_at', 'created_at', 'updated_at'];

    public function comments()
    {
        return $this->morphMany(Comment::class, "model");
    }

    public function likes()
    {
        return $this->morphMany(Like::class, "model");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
    
}
