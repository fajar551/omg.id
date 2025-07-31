<?php

namespace App\Src\Services\Eloquent;

use App\Models\UserBalance;
use App\Src\Validators\UserValidator;
use Illuminate\Support\Facades\DB;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Utils;

class UserBalanceService {
    protected $model;
    protected $validator;

    public function __construct(UserBalance $model, UserValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new UserBalance(), new UserValidator()); 
    }

    public function create(int $user_id)
    {
        $this->validator->validateId($user_id);
        $this->validator->validateBalanceId($user_id);
        $data = array('user_id' => $user_id);
        return $this->model->create($data);
    }

    public function getById(int $user_id)
    {
        $this->validator->validateId($user_id);
        $model = $this->model->where("user_id", $user_id)->first();
        if ($model==null) {
            // $this->create($user_id);
            $model = $this->getReturnedValue($this->create($user_id));
        }
        return $model;
    }
 
    public function transaction_history(int $user_id, $type)
    {
        $where = "";
        if ($type == 'support') {
            $where = "AND SUBSTRING(external_id, 1, 7) = 'PAYMENT'";
        }else if ($type == 'payout'){
            $where = "AND SUBSTRING(external_id, 1, 7) != 'PAYMENT'";
        }
        
        DB::statement("SET sql_mode = '' ");
        $query = DB::select("SELECT id, user_id,  CONCAT('Rp',format(amount, 0)) amount, SUBSTRING(external_id, 1, 7) type, created_at, status, fee
        FROM
                (
                    SELECT supports.id, creator_id user_id, invoices.creator_amount amount, invoices.order_id external_id, supports.created_at, invoices.status, CONCAT('Support Rp',format(invoices.gross_amount, 0),' | ', UPPER(invoices.payment_type), ' ', invoices.pg_fee, '% + PPN 11% | Platform ', invoices.platform_fee, '%') as fee FROM supports INNER JOIN invoices ON invoices.id = supports.invoice_id
                    UNION
                    SELECT id, user_id, payout_amount amount, external_id, created_at, status, CONCAT('Rp',format(payout_fee,0)) fee FROM payouts
                ) s
                    WHERE user_id = '$user_id'
                    AND status != 'pending' AND status != 'failed'
                    $where
                    ORDER BY created_at DESC");

        return datatables()->of($query)
        ->addIndexColumn()
        ->editColumn('type', function($row) {
            return $row->type=="PAYMENT" ? "Support" : "Disbursement";
        })
        ->editColumn('status', function($row) {
            if ($row->status == "settlement" || $row->status == "SUCCEEDED" || $row->status == "completed" || $row->status == "COMPLETED") {
                $status = "Success";
            }else {
                $status = ucwords(strtolower($row->status));
            }
            return $status;
        })
        ->editColumn('created_at', function($row) {
            return Utils::formatDate($row->created_at, true);
        })
        ->editColumn('fee', function($row) {
            $fee = "";
            $data = explode('|', $row->fee);
            foreach ($data as $key){
               $fee .= '<span class="badge badge-pill bg-secondary" style="color: black">'. $key .'</span> ';
            }
            return $fee;
        })
        ->rawColumns(['fee'])
        ->toJson();
    }

    public function exporttransaction(array $params)
    {
        $where = "";
        if ($params['type'] == 'support') {
            $where = "AND SUBSTRING(external_id, 1, 7) = 'PAYMENT'";
        }else if ($params['type'] == 'payout'){
            $where = "AND SUBSTRING(external_id, 1, 7) != 'PAYMENT'";
        }
        if (isset($params['start_at']) && isset($params['end_at'])) {
            $start_at = " AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '". date('Y-m-d', strtotime($params['start_at']))."' ";
            $end_at = " AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '". date('Y-m-d', strtotime($params['end_at']))."' ";
        }else{
            throw new ValidatorException(__("Please select date range before export!"), [
                'start_at' => ['Please select start date!'],
                'end_at' => ['Please select end date!'],
            ]);
        }
        $user_id = $params['user_id'];  
        DB::statement("SET sql_mode = '' ");
        $query = DB::select("SELECT id, user_id, amount, SUBSTRING(external_id, 1, 7) type, DATE_FORMAT(created_at,'%d-%m-%Y %H:%i') created_at, status, fee
        FROM
                (
                    SELECT supports.id, creator_id user_id, invoices.creator_amount amount, invoices.order_id external_id, supports.created_at, invoices.status, CONCAT('Rp',format(invoices.gross_amount, 0),' | ', UPPER(invoices.payment_type), ' ', invoices.pg_fee, '% + PPN 11% | Platform ', invoices.platform_fee, '%') as fee FROM supports INNER JOIN invoices ON invoices.id = supports.invoice_id
                    UNION
                    SELECT id, user_id, payout_amount amount, external_id, created_at, status, CONCAT('Rp',format(payout_fee,0)) fee FROM payouts
                ) s
                    WHERE user_id = '$user_id'
                    $start_at
                    $end_at
                    $where
                    ORDER BY created_at DESC");

        // dd($query);
        return $query;
    }

    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "user_id" => $model->user_id,
            "active" => $model->active,
            "pending" => $model->pending,
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }
}