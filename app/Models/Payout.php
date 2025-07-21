<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payout extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'payouts';
    protected  $fillable = ['user_id', 'payout_account_id', 'payout_date', 'payout_amount', 'payout_fee', 'status', 'external_id'];

    protected static $logAttributes = ["*"];
    protected static $logFillable = true;
    

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function payout_account()
    {
        return $this->belongsTo(PayoutAccount::class, "payout_account_id", "id");
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
