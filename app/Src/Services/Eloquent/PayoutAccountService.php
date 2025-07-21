<?php

namespace App\Src\Services\Eloquent;

use App\Models\PayoutAccount;
use App\Models\User;
use App\Src\Validators\PayoutAccountValidator;
use App\Src\Exceptions\NotFoundException;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Constant;
use App\Src\Jobs\SendEmailVerifyPayoutAccount;

class PayoutAccountService {

    protected $model;
    protected $validator;

    public function __construct(PayoutAccount $model, PayoutAccountValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }
    
    public static function getInstance()
    {
        return new static(new PayoutAccount(), new PayoutAccountValidator());
    }

    public function getdata(int $user_id)
    {
        return $this->model->where("user_id", $user_id)->orderBy("is_primary", "desc")->orderBy("created_at", "asc")->get();
    }

    public function getinactive()
    {
        return $this->model->where("status", 0)->orderBy("updated_at", "desc")->paginate(5);
    }

    public function getactive()
    {
        return $this->model->where("status", 1)->orderBy("updated_at", "asc")->paginate(5);
    }

    public function getById(int $id, int $user_id)
    {
        $model = $this->model->where(['id' => $id, 'user_id' => $user_id])->first();

        if (!$model) {
            throw new NotFoundException(__("message.notfound"), []);
        }

        return $this->getReturnedValue($model);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function store(int $user_id ,array $data)
    {
        $data['user_id'] = $user_id;
        $this->validator->validateStore($data);
        $model = $this->model;
        if ($this->getdata($user_id)->first()==null) {
            $model->is_primary = 1;
        }
        $model->user_id = $user_id;
        $model->channel_code = $data["channel_code"];
        $model->account_name = $data["account_name"];
        $model->account_number = $data["account_number"];
        $model->type = $data["type"];
        $model->save();

        // Notification data
        $notifyData = [
            "payout_account_id" => $model->id,
            "status" => Constant::getPayoutAccountStatus(0),
            "userid" => $model->user_id,
            "name" => $model->user->name,
            "email" => $model->user->email,
            "notifiable_id" => $model->user_id,
        ];

        // Send notify to creator with notifyData
        NotificationService::getInstance()->sendNotificationTo($user_id, 'notify.payout_account_activation', $notifyData);

        // Send notify to user that has role admin with notifyData
        User::role('admin')->get()->map(function($admin) use($notifyData) {
            $notifyData["notifiable_id"] = $admin->id;
            NotificationService::getInstance()->sendNotificationTo($admin->id, 'notify.payout_account_activation', $notifyData);
        });

        return $this->getReturnedValue($model);
    }

    public function editById(int $id, array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->channel_code = $data["channel_code"];
        $model->account_name = $data["account_name"];
        $model->account_number = $data["account_number"];
        $model->type = $data["type"];
        $model->status = 0;
        $model->save();

        // Notification data
        $notifyData = [
            "payout_account_id" => $model->id,
            "status" => Constant::getPayoutAccountStatus(0),
            "userid" => $model->user_id,
            "name" => $model->user->name,
            "email" => $model->user->email,
            "notifiable_id" => $model->user_id,
        ];

        // Send notify to creator with notifyData
        NotificationService::getInstance()->sendNotificationTo($model->user_id, 'notify.payout_account_activation', $notifyData);

        // Send notify to user that has role admin with notifyData
        User::role('admin')->get()->map(function($admin) use($notifyData) {
            $notifyData["notifiable_id"] = $admin->id;
            NotificationService::getInstance()->sendNotificationTo($admin->id, 'notify.payout_account_activation', $notifyData);
        });

        return $this->getReturnedValue($model);
    }

    public function deleteById($id, $user_id)
    {
        $model = $this->model->where(['id' => $id, 'user_id' => $user_id])->first();

        if (!$model) {
            throw new NotFoundException(__("message.notfound"), []);
        }
        if ($model->is_primary == 1) {
            throw new ValidatorException(__("message.delete_primary_payout_account"), []);
        }

        return $model->delete();
    }

    public function setprimary(int $id, int $user_id)
    {
        $this->validator->validateId($id);

        $this->model->where("user_id", $user_id)->update(array("is_primary" => 0));
        $model = $this->findById($id);
        $model->is_primary = 1;
        $model->save();
        return ["result" => __("message.payout_accout_setprimary")];
    }

    public function setstatus(int $id)
    {
        $model = $this->findById($id);
        if ($model->channel_code == 'dana' || $model->channel_code == 'ovo' || $model->channel_code == 'linkaja') {
            $check_first_number = substr($model->account_number, 0, 2);
            if ($check_first_number == 62) {
                $model->account_number = (int) 0 . substr($model->account_number, strlen(62));
            }
        }elseif ($model->channel_code == 'gopay' || $model->channel_code == 'shopeepay' || $model->channel_code == 'qris') {
            $check_first_number = substr($model->account_number, 0, 1);
            if ($check_first_number == 0) {
                $model->account_number = (int) 62 . substr($model->account_number, strlen(0));
            }
        }
        
        $model->status = 1;
        $model->save();

        // Notification data
        $notifyData = [
            "payout_account_id" => $model->id,
            "userid" => $model->user_id,
            "name" => $model->user->name,
            "email" => $model->user->email,
            "status" => Constant::getPayoutAccountStatus($model->status),
            'data' => $this->getReturnedValue($model),
            "notifiable_id" => $model->user_id,
        ];

        // Send notify to creator with notifyData
        // SendEmailVerifyPayoutAccount::dispatch(array('email' => $model->user->email, 'data' => $this->getReturnedValue($model)));
        NotificationService::getInstance()->sendNotificationTo($model->user_id, 'notify.payout_account_verified', $notifyData);

        return ["result" => __("message.payout_accout_setactive")];
    }

    public function getprimary($user_id)
    {
        return $this->model->where(array('user_id' => $user_id, 'is_primary' => 1))->first();
    }

    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "user_id" => $model->user_id,
            "channel_code" => $model->channel_code,
            "account_name" => $model->account_name,
            "account_number" => $model->account_number,
            "is_primary" => @$model->is_primary,
            "status" => @$model->status,
            "type" => $model->type,
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }
}