<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayoutChannel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payout_channels';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
}
