<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Goal extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'goals';
    protected $guarded = [];
    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at', 'deleted_at'];

    protected static $logAttributes = ["*"];
    protected static $logFillable = true;
    
    public function scopeInactive($query)
    {
        return $query->where("status", 0);
    }

    public function scopeActive($query)
    {
        return $query->where("status", 1);
    }

    public function scopeReached($query)
    {
        return $query->where("status", 2);
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function supports()
    {
        return $this->hasMany(Support::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
            // ->logOnly(['id', 'title', 'target', 'type', 'description', 'visibility', 'status', 'enable_milestone', 'start_at', 'end_at']);
        // Chain fluent methods for configuration options
    }
}
