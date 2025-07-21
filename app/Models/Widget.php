<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Widget extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'widgets';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];

    protected static $logAttributes = ["*"];
    protected static $logFillable = true;

    public function users()
    {
        return $this->belongsToMany(Widget::class, "user_widgets", "widget_id", "user_id")->withTimestamps();

    }
    
    public function settings()
    {
        return $this->hasMany(WidgetSetting::class, "widget_id", "id");
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
