<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $guarded = [];
    protected $dates = ["created_at", "updated_at", "due_date", "date_canceled", "date_paid", "date_active"];

    public function support()
    {
        return $this->hasOne(Support::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

}
