<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SocialLink extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'social_links';
    protected $fillable = ['user_id', 'name', 'page_url'];
    protected $dates = ['created_at', 'udpated_at'];

    protected static $logAttributes = ["*"];
    protected static $logFillable = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
