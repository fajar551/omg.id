<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class WidgetSetting extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'widget_settings';
    protected $fillable = ['user_id', 'widget_id', 'name', 'value', 'data_type'];
    protected $dates = ['created_at', 'updated_at'];

    protected static $logAttributes = ["*"];
    protected static $logFillable = true;

    public function widget()
    {
        return $this->belongsTo(Widget::class, "widget_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
