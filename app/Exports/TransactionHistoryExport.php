<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Src\Services\Eloquent\UserBalanceService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionHistoryExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function __construct(array $params){
        $this->params = $params;
    }

    public function view(): View
    {
        return view('export.transaction-history', [
            'data' => UserBalanceService::getInstance()->exporttransaction($this->params),
            'params' => $this->params
        ]);
    }
}
