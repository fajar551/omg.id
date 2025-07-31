<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWidget extends Model
{
    use HasFactory;
    protected $table = 'user_widgets';
    protected $fillable = ['user_id', 'widget_id', 'is_used'];
    protected $dates = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
