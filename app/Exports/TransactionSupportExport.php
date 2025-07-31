<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Src\Services\Eloquent\TransactionService;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionSupportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function __construct(array $params){
        $this->params = $params;
    }

    public function view(): View
    {
        return view('export.support', [
            'data' => TransactionService::getInstance()->supporthistory($this->params)
        ]);
    }
}
