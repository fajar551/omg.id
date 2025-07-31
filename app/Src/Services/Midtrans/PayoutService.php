<?php

namespace App\Src\Services\Midtrans;

use App\Models\Payout;
use App\Models\PayoutAccount;
use App\Models\UserBalance;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Utils;
use App\Src\Jobs\SendEmailPayoutJob;
use App\Src\Services\Eloquent\NotificationService;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Validators\PayoutValidator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayoutService extends Midtrans {

    protected $PAmodel;
    protected $userbalance;
    protected $model;
    protected $validator;
    protected $approveKey;

    public function __construct(PayoutAccount $PAmodel, Payout $model, UserBalance $userbalance, PayoutValidator $validator)
    {
        parent::__construct();
        $this->PAmodel = $PAmodel;
        $this->userbalance = $userbalance;
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new PayoutAccount(), new Payout(), new UserBalance(), new PayoutValidator());
    }

    public function create(int $user_id, int $amount)
    {
        try {
            $this->validator->validateAmount(['amount' => $amount]);

            $fee = SettingService::getInstance()->get('payout_fee') + (SettingService::getInstance()->get('payout_fee')*(SettingService::getInstance()->get('ppn')/100));
            $total_payout = $amount + $fee;
            // dd($fee);
            $PAmodel = $this->PAmodel->where([
                "is_primary" => 1,
                "status" => 1,
                "user_id" => $user_id
            ])->first();
            // return $PAmodel;
            if ($PAmodel == null) {
                throw new ValidatorException(__("message.setup_payout_account"), null);
            }

            $userbalance = $this->userbalance->where(array('user_id' => $user_id))->first();
            if ($userbalance == null) {
                throw new ValidatorException(__("message.setup_user_balance"), null);
            }
            if ($amount < 50000) {
                throw new ValidatorException(__("message.minimum_payout"), null);
            }
            if ($userbalance->active < $total_payout) {
                throw new ValidatorException(__("message.amount_active_not_enough"), null);
            }

            $payload = [
                "payouts" => [
                    [
                        "beneficiary_name" => $PAmodel->account_name,
                        "beneficiary_account" => (string) $PAmodel->account_number,
                        "beneficiary_bank" => $PAmodel->channel_code,
                        "amount" => $amount,
                        "notes" => (string) 'PAYOUT' . $user_id . date('YmdHis')
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->withBasicAuth($this->payoutKey, '')->post($this->payoutUrl . '/api/v1/payouts', $payload);

            $model = $this->model;
            $model->user_id = $user_id;
            $model->payout_account_id = $PAmodel->id;
            $model->payout_date = date('Y-m-d H:i:s');
            $model->status = $response['payouts'][0]['status'];
            $model->payout_amount = $amount;
            $model->payout_fee = $fee;
            $model->external_id = $response['payouts'][0]['reference_no'];
            if ($response['payouts'][0]['status'] == 'queued') {
                $approve = $this->approve($response['payouts'][0]['reference_no']);
                if($approve['status']=='ok') {
                    $model->save();
                    $detailemail = [
                        "external_id" => $response['payouts'][0]['reference_no'],
                        "status" => $response['payouts'][0]['status'],
                        "amount" => Utils::toIDR($amount),
                        "fee" => Utils::toIDR($fee),
                        "payout_channel" => $PAmodel->channel_code,
                        "payout_name" => $PAmodel->account_name,
                        "payout_number" => $PAmodel->account_number,
                        "created_at" => date('Y-m-d H:i:s')
                    ];

                    $userbalance = $this->userbalance->where(array('user_id' => $user_id))->first();
                    $userbalance->active = $userbalance->active - $total_payout;
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
            }
            
            return $response;

        } catch (\Throwable $th) {
            return "Error: " . $th->getMessage();
        }
    }

    public function callback(array $data)
    {
        // Log::info($data);
        $this->validator->validateExternalid($data['reference_no']);
        $model = $this->model->where(array('external_id' => $data['reference_no']))->first();
        $PAmodel = $this->PAmodel->where(array("id" => $model->payout_account_id))->first();
        // return $data['status'];
        if ($model->status != 'completed') {
            $model->status = $data['status'];
        
            if ($data['status'] == 'failed') {
                $userbalance = $this->userbalance->where(array('user_id' => $model->user_id))->first();
                $userbalance->active = $userbalance->active + ($model->payout_amount + $model->payout_fee);
                $userbalance->save();
            }

            $detailemail = [
                "external_id" => $data['reference_no'],
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

    public function approve(string $reference_no)
    {
        $payload = array(
            'reference_nos' => [$reference_no]
        );
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBasicAuth($this->approveKey, '')->post($this->payoutUrl . '/api/v1/payouts/approve', $payload);
        return $response;
    }

    public function check_balance()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->withBasicAuth($this->payoutKey, '')->get($this->payoutUrl . '/api/v1/balance');
        // dd($response);
        return $response;
    }
}
