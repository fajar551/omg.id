<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportDetail extends Model
{
    use HasFactory;

    protected $table = 'support_details';
    protected $fillable= ['support_id', 'item_id', 'price', 'qty', 'total'];
    protected $dates = ['created_at', 'updated_at'];

    public function suppport()
    {
        return $this->belongsTo(Support::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

}
