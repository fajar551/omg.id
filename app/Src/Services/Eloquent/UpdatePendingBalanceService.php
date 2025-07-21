<?php

namespace App\Src\Services\Eloquent;

use App\Models\Invoice;
use App\Models\UserBalance;

class UpdatePendingBalanceService
{
    protected $modelInvoice;
    protected $modelUserBalance;

    public function __construct(Invoice $modelInvoice, UserBalance $modelUserBalance)
    {
        $this->modelInvoice = $modelInvoice;
        $this->modelUserBalance = $modelUserBalance;
    }

    public static function getInstance() {
        return new static(new Invoice(), new UserBalance());
    }

    public function updatebalance()
    {
        $modelInvoice = $this->modelInvoice
                            ->where('is_amount_active', 0)
                            ->whereIn('status', ['SUCCEEDED', 'COMPLETED', 'capture', 'settlement', 'Success'])
                            ->where(Invoice::raw("(DATE_FORMAT(date_active,'%Y-%m-%d %H:%i'))"), '<=', now()->format('Y-m-d H:i'))
                            ->get();
        
        foreach ($modelInvoice as $a) {
            $modelUserBalance = $this->modelUserBalance->where('user_id', $a->support->creator_id)->first();
            $modelUserBalance->pending = $modelUserBalance->pending - $a->creator_amount;
            $modelUserBalance->active = $modelUserBalance->active + $a->creator_amount;
            $modelUserBalance->save();
            $a->is_amount_active = 1;
            $a->save();
        }
    }
}
