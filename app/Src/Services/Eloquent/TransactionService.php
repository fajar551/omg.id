<?php

namespace App\Src\Services\Eloquent;

use App\Models\Invoice;
use App\Models\Payout;
use App\Models\Support;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class TransactionService
{

    protected $modelSupport;
    protected $modelInvoice;
    protected $modelPayout;

    public function __construct(Support $modelSupport, Invoice $modelInvoice, Payout $modelPayout)
    {
        $this->modelSupport = $modelSupport;
        $this->modelInvoice = $modelInvoice;
        $this->modelPayout = $modelPayout;
    }

    public static function getInstance()
    {
        return new static(new Support(), new Invoice(), new Payout());
    }

    public function supporthistory(array $params)
    {
        $query = $this->modelInvoice->whereHas('support', function ($row) use ($params) {
            return $row->where('status', 1);
        });

        if (isset($params['creator_name'])) {
            $query->whereHas('support', function ($row) use ($params) {
                return $row->where('creator_id', $params['creator_name']);
            });
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $query->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        } else {
            throw new ValidatorException(__("Please select date range before export!"), [
                'start_at' => ['Please select start date!'],
                'end_at' => ['Please select end date!'],
            ]);
        }

        if (isset($params['payment_type']) && $params['payment_type'] != 0) {
            $query->where('payment_method_id', $params['payment_type']);
        }

        $query = $query->get();

        $data = [];

        foreach ($query as $row) {
            $data[] = [
                'creator_name' => $row->support->creator->name,
                'order_id' => $row->order_id,
                'date' => $row->created_at->format('d-m-Y'),
                'status' => $row->status,
                'payment_method' => strtoupper($row->payment_type),
                'gross_amount' => Utils::toIDR($row->gross_amount),
                'pg_fee' => $row->pg_fee,
                'pg_amount' => Utils::toIDR($row->pg_amount),
                'platform_fee' => $row->platform_fee,
                'platform_amount' => Utils::toIDR($row->platform_amount),
                'creator_amount' => Utils::toIDR($row->creator_amount)
            ];
        }

        // dd($data);
        return $data;
    }

    public function getsupports(array $params)
    {
        $query = $this->modelInvoice->whereHas('support', function ($row) use ($params) {
            return $row->where('status', 1);
        });

        if (isset($params['creator_name'])) {
            $query->whereHas('support', function ($row) use ($params) {
                return $row->where('creator_id', $params['creator_name']);
            });
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $query->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        }

        if (isset($params['payment_type']) && $params['payment_type'] != 0) {
            $query->where('payment_method_id', $params['payment_type']);
        }
        $query->orderBy('created_at', 'DESC');

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('creator_name', function ($row) {
                return $row->support->creator->name;
            })
            ->addColumn('date', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('detail', function ($row) {
                $summaries = [
                    __("Payment Type") => strtoupper($row->payment_type),
                    __("Gross Amount") => Utils::toIDR($row->gross_amount),
                    __("PG Fee") => $row->pg_fee,
                    __("PG Amount") => Utils::toIDR($row->pg_amount),
                    __("Platform Fee") => $row->platform_fee,
                    __("Platform Amount") => Utils::toIDR($row->platform_amount),
                    __("Creator Amount") => Utils::toIDR($row->creator_amount),
                    // TODO: Add more summaries
                ];
                $id = $row->id;
                return View::make('components.support-detail', compact('summaries', 'id'));
            })
            ->toJson();
    }

    public function amountpermonth($params)
    {

        $query = $this->modelInvoice->whereHas('support', function ($row) use ($params) {
            return $row->where('status', 1);
        });

        if (isset($params['creator_name'])) {
            $query->whereHas('support', function ($row) use ($params) {
                return $row->where('creator_id', $params['creator_name']);
            });
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $query->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        }

        if (isset($params['payment_type']) && $params['payment_type'] != 0) {
            $query->where('payment_method_id', $params['payment_type']);
        }
        // dd($query->get()->sum('creator_amount'));

        return Utils::toIDR($query->get()->sum('creator_amount'));
    }

    public function platformamount($params = null)
    {

        $query = $this->modelInvoice->whereHas('support', function ($row) use ($params) {
            return $row->where('status', 1);
        });

        if (isset($params['creator_name'])) {
            $query->whereHas('support', function ($row) use ($params) {
                return $row->where('creator_id', $params['creator_name']);
            });
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $query->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        }

        if (isset($params['payment_type']) && $params['payment_type'] != 0) {
            $query->where('payment_method_id', $params['payment_type']);
        }
        return Utils::toIDR($query->get()->sum('platform_amount'));
    }

    public function totalsupport($params)
    {
        $modelSupport = $this->modelSupport
            ->where('status', 1);
        if (isset($params['creator_id'])) {
            $modelSupport = $modelSupport->where('creator_id', $params['creator_id']);
        }
        if (isset($params['payment_type']) && $params['payment_type'] != 0) {
            $modelSupport = $modelSupport->whereHas('invoice', function ($row) use ($params) {
                return $row->where('payment_method_id', $params['payment_type']);
            });
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $modelSupport = $modelSupport->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $modelSupport = $modelSupport->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        }
        $modelSupport = $modelSupport->get()
            ->count();
        // dd($modelSupport);
        return $modelSupport;
    }



    public function getdisbursement(array $params)
    {
        $query = $this->modelPayout->query();

        if (isset($params['creator_name'])) {
            $query->where('user_id', $params['creator_name']);
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $query->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        }

        if (isset($params['type']) && $params['type'] != 0) {
            $query->whereHas('payout_account', function ($row) use ($params) {
                return $row->where('type', $params['type']);
            });
        }

        $query->orderBy('created_at', 'DESC');
        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('creator_name', function ($row) {
                return $row->user->name;
            })
            ->addColumn('date', function ($row) {
                return $row->created_at->format('d-m-Y');
            })
            ->editColumn('payout_amount', function ($row) {
                return Utils::toIDR($row->payout_amount);
            })
            ->editColumn('payout_fee', function ($row) {
                return Utils::toIDR($row->payout_fee);
            })
            ->addColumn('detail', function ($row) {
                $summaries = [
                    __("Channel Code") => $row->payout_account->channel_code,
                    __("Account Name") => $row->payout_account->account_name,
                    __("Account Number") => $row->payout_account->account_number,
                    __("Type") => Constant::getPayoutType($row->payout_account->type),
                    // TODO: Add more summaries
                ];
                $id = $row->id;
                return View::make('components.payout-detail', compact('summaries', 'id'));
            })
            ->toJson();
    }

    public function totalpayout($params)
    {
        $modelPayout = $this->modelPayout;
        if (isset($params['creator_id'])) {
            $modelPayout = $modelPayout->where('user_id', $params['creator_id']);
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $modelPayout = $modelPayout->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $modelPayout = $modelPayout->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        }

        if (isset($params['type']) && $params['type'] != 0) {
            $modelPayout = $modelPayout->whereHas('payout_account', function ($row) use ($params) {
                return $row->where('type', $params['type']);
            });
        }

        $modelPayout = $modelPayout->get()
            ->count();
        // dd($modelSupport);
        return $modelPayout;
    }

    public function payoutamount($params)
    {
        $total = 0;
        $modelPayout = $this->modelPayout;
        if (isset($params['creator_id'])) {
            $modelPayout = $modelPayout->where('creator_id', $params['creator_id']);
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $modelPayout = $modelPayout->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $modelPayout = $modelPayout->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        }

        if (isset($params['type']) && $params['type'] != 0) {
            $modelPayout = $modelPayout->whereHas('payout_account', function ($row) use ($params) {
                return $row->where('type', $params['type']);
            });
        }

        $modelPayout = $modelPayout->where('status', 'completed')->get()->sum('payout_amount');
        // ->map(function($modelPayout, $total) {
        //     return $total = $total + $modelPayout('payout_amount');
        //     // return $modelPayout->sum('payout_amount');
        // });
        // foreach ($modelPayout as $row) {
        //     $total = $total + $row->payout_amount;
        // }
        // dd($modelPayout);
        return Utils::toIDR($modelPayout);
    }

    public function payouthistory(array $params)
    {
        $query = $this->modelPayout->query();

        if (isset($params['creator_name'])) {
            $query->where('user_id', $params['creator_name']);
        }

        if (isset($params['start_at']) && isset($params['end_at'])) {
            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime($params['start_at'])));
            $query->whereDate('created_at', '<=', date('Y-m-d', strtotime($params['end_at'])));
        } else {
            throw new ValidatorException(__("Please select date range before export!"), [
                'start_at' => ['Please select start date!'],
                'end_at' => ['Please select end date!'],
            ]);
        }

        if (isset($params['type']) && $params['type'] != 0) {
            $query->whereHas('payout_account', function ($row) use ($params) {
                return $row->where('type', $params['type']);
            });
        }

        $query = $query->get();

        $data = [];

        foreach ($query as $row) {
            $data[] = [
                'creator_name' => $row->user->name,
                'date' => $row->created_at->format('d-m-Y'),
                'status' => $row->status,
                'payout_amount' => Utils::toIDR($row->payout_amount),
                'payout_fee' => Utils::toIDR($row->payout_fee),
                'channel_code' => $row->payout_account->channel_code,
                'account_name' => $row->payout_account->account_name,
                'account_number' => $row->payout_account->account_number,
                'type' => Constant::getPayoutType($row->payout_account->type)
            ];
        }

        // dd($data);
        return $data;
    }

    public function totalcountperdays($user_id, $filter = null)
    {
        $data = [];

        if ($filter == null) {
            $filter = 30;
        }
        for ($i = $filter; $i >= 0; --$i) {
            // $date = Carbon::createFromDate(now()->year, now()->month, $i);
            $date = now()->subDays($i);
            $modelSupport = $this->modelSupport
                ->where('status', 1)
                ->where('creator_id', $user_id)
                ->where(Support::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->get()
                ->groupBy('email')
                ->count();
            $data[] = [$date->format('d M Y') => $modelSupport];
        }
        return $data;
    }

    public function totalamountperdays($user_id, $filter = null)
    {
        $data = [];
        if ($filter == null) {
            $filter = 30;
        }

        for ($i = $filter; $i >= 0; --$i) {
            // $date = Carbon::createFromDate(now()->year, now()->month, $i);
            $date = now()->subDays($i);
            $modelSupport = $this->modelSupport
                ->where('status', 1)
                ->where('creator_id', $user_id)
                ->where(Support::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->get()
                ->map(function ($modelSupport) {
                    return $modelSupport->invoice()
                        ->sum('creator_amount');
                })->toArray();
            $data[] = [$date->format('d M Y') => round(array_sum($modelSupport))];
        }
        return $data;
    }

    public function platformamountperdays($filter = null)
    {
        $data = [];
        if ($filter == null) {
            $filter = 30;
        }
        for ($i = $filter; $i >= 0; --$i) {
            // $date = Carbon::createFromDate(now()->year, now()->month, $i);
            $date = now()->subDays($i);
            $modelSupport = $this->modelSupport
                ->where('status', 1)
                ->where(Support::raw("(DATE_FORMAT(created_at,'%Y-%m-%d'))"), $date->format('Y-m-d'))
                ->get()
                ->map(function ($modelSupport) {
                    return $modelSupport->invoice()
                        ->sum('platform_amount');
                })->toArray();
            $data[] = [$date->format('d-m-Y') => round(array_sum($modelSupport))];
        }
        return $data;
    }
}
