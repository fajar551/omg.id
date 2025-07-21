<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Item extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'items';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    
    protected static $logAttributes = ["*"];
    protected static $logFillable = true;

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }

    public function supportDetails()
    {
        return $this->hasMany(SupportDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id', 'name', 'price', 'icon', 'description', 'is_active', 'is_default']);
        // Chain fluent methods for configuration options
    }
}
