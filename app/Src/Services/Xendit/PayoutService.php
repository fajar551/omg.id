<?php

namespace App\Src\Services\Xendit;

use App\Models\Payout;
use App\Models\PayoutAccount;
use App\Models\UserBalance;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Utils;
use App\Src\Jobs\SendEmailPayoutJob;
use App\Src\Services\Eloquent\NotificationService;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Services\Midtrans\PayoutService as MidtransPayoutService;
use App\Src\Validators\PayoutValidator;
use Illuminate\Support\Facades\Log;
use Xendit\Xendit;
use Illuminate\Support\Str;

class PayoutService extends Xendits
{

    protected $PAmodel;
    protected $userbalance;
    protected $model;
    protected $validator;

    public function __construct(PayoutAccount $PAmodel, UserBalance $userbalance, Payout $model, PayoutValidator $validator){
        parent::__construct();
        $this->PAmodel = $PAmodel;
        $this->userbalance = $userbalance;
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new PayoutAccount(), new UserBalance(), new Payout(), new PayoutValidator());
    }

    /**
     * fungsi pencairan dana menggunakan xendit
     */
    public function disbursement(int $user_id, array $data)
    {
        // validasi minimum payout
        $this->validator->validateAmount(['amount' => $data['amount']]);
        
        // perhitungan fee
        $fee = SettingService::getInstance()->get('payout_fee') + (SettingService::getInstance()->get('payout_fee')*(SettingService::getInstance()->get('ppn')/100));
        $total_payout = $data['amount'] + $fee;

        // cek akun payout account user
        $PAmodel = $this->PAmodel->where(array("is_primary" => 1,"status" => 1, "user_id" => $user_id))->first();
        
        if ($PAmodel==null) {
            throw new ValidatorException(__("message.setup_payout_account"), ["amount"=>[__("message.setup_payout_account")]]);
        }

        // cek saldo pada balance account user
        $userbalance = $this->userbalance->where(array('user_id' => $user_id))->first();
        if ($userbalance==null) {
            throw new ValidatorException(__("message.setup_user_balance"), ["amount"=>[__("message.setup_user_balance")]]);
        }
        if ($data['amount'] < 50000) {
            throw new ValidatorException(__("message.minimum_payout"), ["amount"=>[__("message.minimum_payout")]]);
        }
        if ($userbalance->active < $total_payout) {
            throw new ValidatorException(__("message.amount_active_not_enough"), ["amount"=>[__("message.amount_active_not_enough")]]);
        }

        // cek payment method yang dipilih untuk menentukan payment gateway yang digunakan

        // Payement gateway xendit
        if ($PAmodel->channel_code == 'ovo' || $PAmodel->channel_code == 'dana' || $PAmodel->channel_code == 'linkaja' || $PAmodel->channel_code == 'sahabat_sampoerna' || $PAmodel->channel_code == 'mega') {
        
            $params = [
                'external_id' => 'PAYOUT-' . $user_id . Str::random(10) . date('YmdHis'),
                'amount' => (double) $data['amount'],
                'bank_code' => strtoupper($PAmodel->channel_code),
                'account_holder_name' => $PAmodel->account_name,
                'account_number' => (string) $PAmodel->account_number,
                'description' => 'Payout active amount',
                'X-IDEMPOTENCY-KEY' => (string) $user_id . date('YmdHis')
            ];
            
            $result = \Xendit\Disbursements::create($params);

            $model = $this->model;
            $model->user_id = $user_id;
            $model->payout_account_id = $PAmodel->id;
            $model->payout_date = date('Y-m-d H:i:s');
            $model->status = $result['status'];
            $model->payout_amount = $result['amount'];
            $model->payout_fee = $fee;
            $model->external_id = $result['external_id'];
            if ($result['status'] == 'PENDING') {
                $model->save();
                
                $detailemail = [
                    "external_id" => $result['external_id'],
                    "status" => $result['status'],
                    "amount" => Utils::toIDR($data['amount']),
                    "fee" => Utils::toIDR($fee),
                    "payout_channel" => $PAmodel->channel_code,
                    "payout_name" => $PAmodel->account_name,
                    "payout_number" => $PAmodel->account_number,
                    "created_at" => date('Y-m-d H:i:s')
                ];

                $userbalance = $this->userbalance->where(array('user_id' => $user_id))->first();
                $userbalance->active = $userbalance->active - ($result['amount'] + SettingService::getInstance()->get('payout_fee'));
                $userbalance->save();

                // SendEmailPayoutJob::dispatch(array('email' => $model->user->email, 'data' => $detailemail));
                // Notification data
                $notifyData = [
                    'notifiable_id' => $model->user_id,
                    'data' => $detailemail,
                ];

                // Send notify to creator with notifyData
                NotificationService::getInstance()->sendNotificationTo($model->user_id, 'notify.disbursement_request', $notifyData);
            }
            

            return $result;

        // payment gateway midtrans
        }else{
            MidtransPayoutService::getInstance()->create($user_id,  $data['amount']);
        }
    }

    // callback untuk menerima payload dari xendit
    public function callback(array $data)
    {
        // validasi payload
        $this->validator->validateExternalid($data['external_id']);
        $model = $this->model->where(array('external_id' => $data['external_id']))->first();
        $PAmodel = $this->PAmodel->where(array("id" => $model->payout_account_id))->first();
        // return $data['status'];
        
        // cek status response dari xendit
        if ($model->status != 'COMPLETED') {
            $model->status = $data['status'];
        
            // mengembalikan saldo ke balance saat proses pencairan gagal
            if ($data['status'] == 'FAILED') {
                $userbalance = $this->userbalance->where(array('user_id' => $model->user_id))->first();
                $userbalance->active = $userbalance->active + ($data['amount'] + $model->payout_fee);
                $userbalance->save();
            }

            $detailemail = [
                "external_id" => $data['external_id'],
                "status" => $data['status'],
                "amount" => Utils::toIDR($data['amount']),
                "fee" => Utils::toIDR($model->payout_fee),
                "payout_channel" => $PAmodel->channel_code,
                "payout_name" => $PAmodel->account_name,
                "payout_number" => $PAmodel->account_number,
                "created_at" => $model->created_at->format(Utils::defaultDateTimeFormat())
            ];

            // SendEmailPayoutJob::dispatch(array('email' => $model->user->email, 'data' => $detailemail));
            // Notification data
            $notifyData = [
                'notifiable_id' => $model->user_id,
                'data' => $detailemail,
            ];

            // Send notify to creator with notifyData
            NotificationService::getInstance()->sendNotificationTo($model->user_id, 'notify.disbursement_request', $notifyData);
            
            return $model->save();
        } else {
            return ['message' => 'Already updated'];
        }
        
    }

    public function totalpayout(int $user_id)
    {
        $model = $this->model->where(array('user_id' => $user_id, 'status' => 'COMPLETED'))->sum('payout_amount');
        return $model;
    }

    public function history(int $user_id, array $params = [])
    {
        $model = $this->model->where(array('user_id' => $user_id))->orderBy('created_at', "desc");
        if (isset($params['from_date']) && isset($params['to_date'])) {
            $model->whereDate('created_at', '>=', $params['from_date']);
            $model->whereDate('created_at', '<=', $params['to_date']);
        } else {
            $model->whereMonth('created_at', now()->month);
        }
        $model->get();

        return $model;
    }
}