<?php

namespace App\Exports;

use App\Models\Payout;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Src\Services\Eloquent\TransactionService;

class TransactionDisbursementExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(array $params){
        $this->params = $params;
    }

    public function view(): View
    {
        return view('export.disbursement', [
            'data' => TransactionService::getInstance()->payouthistory($this->params)
        ]);
    }
}
