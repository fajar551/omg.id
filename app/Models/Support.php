<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Support extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'supports';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    protected $casts = [
        'media_share' => 'array',
    ];

    protected static $logAttributes = ["*"];
    protected static $logFillable = true;

    public function creator()
    {
        return $this->belongsTo(User::class, "creator_id", "id");
    }

    public function supporter()
    {
        return $this->belongsTo(User::class, "supporter_id", "id");
    }

    public function details()
    {
        return $this->hasMany(SupportDetail::class);
    }
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function scopePaidSuccess($query)
    {
        return $query->where("status", 1);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

}
