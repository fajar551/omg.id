<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $table = 'followers';
    protected $fillable = ['user_id', 'followers_id'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
