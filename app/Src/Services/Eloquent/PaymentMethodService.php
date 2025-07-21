<?php

namespace App\Src\Services\Eloquent;

use App\Models\PaymentMethod;
use App\Src\Base\IBaseService;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\PaymentMethodValidator;
use Illuminate\Support\Str;

class PaymentMethodService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(PaymentMethod $model, PaymentMethodValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new PaymentMethod(), new PaymentMethodValidator());
    }

    public function getDetail(int $id)
    {
        $model = $this->findById($id);

        return $this->formatResult($model);
    }

    public function getList()
    {
        return $this->model->where('disabled', null)->orderBy('order', 'ASC')->get()
                        ->map(function($model) {
                            return $this->formatResult($model);
                        });
    }

    public function getPaymentMethods()
    {
        $pm = [];
        $this->model->orderBy('order', 'ASC')->get()
                    ->map(function($model) use(&$pm) {
                        if ($model->payment_type == 'bank_transfer') {
                            $pm['bank transfer'][] = $this->formatResult($model);
                        } else {
                            $pm['e wallet'][] = $this->formatResult($model);
                        }

                        return $model;
                    });

        return $pm;
    }

    public function store(array $data, $uploadService)
    {
        $this->validator->validateStore($data);
        
        $model = $this->model;
        $model->name = ucwords($data["name"]);
        $model->payment_type = $data["payment_type"];
        $model->bank_name = @$data["bank_name"];
        $model->type = @$data["type"];
        $model->order = @$data["order"];

        $uploadData = [
            "prefix" => "image",
            "path" => Constant::PAYMENT_METHOD_IMAGE_PATH,
            "file" => @$data["image"],
        ];

        $model->image = $uploadService->upload($uploadData);
        $model->save();

        return $this->formatResult($model);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function editById(int $id, array $data, $uploadService)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->name = ucwords($data["name"]);
        $model->payment_type = $data["payment_type"];
        $model->bank_name = @$data["bank_name"];
        $model->type = @$data["type"];
        $model->order = @$data["order"];

        if (isset($data["image"])) {
            $uploadData = [
                "prefix" => "image",
                "path" => Constant::PAYMENT_METHOD_IMAGE_PATH,
                "file" => @$data["image"],
            ];

            if ($model->image) {
                $uploadData["old_file"] = Constant::PAYMENT_METHOD_IMAGE_PATH ."/{$model->image}";
            }

            $model->image = $uploadService->upload($uploadData);
        }

        $model->save();

        return $this->formatResult($model);
    }

    public function changeIcon(array $data)
    {
        $this->validator->validateChangeIcon($data);

        $model = $this->findById($data['id']);
        if (isset($data["image"])) {
            $uploadData = [
                "prefix" => "image",
                "path" => Constant::PAYMENT_METHOD_IMAGE_PATH,
                "file" => @$data["image"],
            ];

            if ($model->image) {
                $uploadData["old_file"] = Constant::PAYMENT_METHOD_IMAGE_PATH ."/{$model->image}";
            }

            $model->image = UploadService::getInstance()->upload($uploadData);
        }

        $model->save();

        return $this->formatResult($model);
    }

    public function deleteById(int $id, $uploadService)
    {
        $model = $this->findById($id);

        $oldFile = Constant::PAYMENT_METHOD_IMAGE_PATH ."/{$model->image}";
        $uploadService->delete($oldFile);

        return $model->delete();
    }

    public function setActive($id)
    {
        $model = $this->findById($id);
        if ($model->disabled == 1) {
            $model->disabled = NULL;
            $model->save();
        }else {
            $model->disabled = 1;
            $model->save();
        }

        return ["result" => $model->disabled == null ? __("Payment Method Activated") : __("Payment Method Disabled")];
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "payment_type" => $model->payment_type,
            "bank_name" => $model->bank_name,
            "type" => $model->type,
            "image" => route("api.paymentmethod.preview", ["file_name" => $model->image ?: Constant::UNKNOWN_STATUS]),
            "disabled" => $model->disabled,
            "order" => $model->order,
            "created_at" => Utils::formatDate($model->created_at, true),
            "updated_at" => Utils::formatDate($model->updated_at, true),
        ];
    }

    public function preview($filename, $uploadService)
    {
        return $uploadService->preview(Constant::PAYMENT_METHOD_IMAGE_PATH ."/$filename");
    }

}