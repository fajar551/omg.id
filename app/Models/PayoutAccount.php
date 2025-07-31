<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PayoutAccount extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'payout_accounts';
    protected $fillable = ['user_id', 'channel_code', 'account_name', 'account_number', 'is_primary', 'status', 'type'];

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
