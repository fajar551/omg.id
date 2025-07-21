<?php

namespace App\Src\Services\Eloquent;

use App\Models\Item;
use App\Src\Exceptions\NotFoundException;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\ItemValidator;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class ItemService {

    protected $model;
    protected $validator;

    public function __construct(Item $model, ItemValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new Item(), new ItemValidator());
    }

    public function getDetail(int $id)
    {
        $model = $this->findById($id);

        return $this->formatResult($model);
    }

    public function getUserItem($userid, $itemid)
    {
        $model = $this->model->where("user_id", $userid)->find($itemid);
        if (!$model) {
            throw new NotFoundException(__("message.notfound"), []);
        }

        return $this->formatResult($model);
    }

    public function getItems(int $userid)
    {
        return $this->model->where("user_id", $userid)
                        ->oldest("price")
                        ->get()
                        ->map(function($model) {
                            return $this->formatResult($model);
                        });
    }

    public function getActiveItems(int $userid)
    {
        return $this->model->where("user_id", $userid)
                        ->active()
                        ->oldest("price")
                        ->get()
                        ->map(function($model) {
                            return $this->formatResult($model);
                        });
    }

    public function getDefaultItems()
    {
        return $this->model->where("is_default", 1)
            ->where("user_id", NULL)
            ->get()
            ->map(function ($model) {
                return $this->formatResult($model);
            });
    }

    public function changeIcon(array $data)
    {
        $this->validator->validateChangeIcon($data);

        $model = $this->findById($data['id']);
        if (isset($data["icon"])) {
            $uploadData = [
                "prefix" => "item",
                "path" => Constant::ITEM_UPLOAD_PATH,
                "file" => @$data["icon"],
            ];

            if ($model->icon && $model->icon != 'coin.png') {
                $uploadData["old_file"] = Constant::ITEM_UPLOAD_PATH . "/{$model->icon}";
            }

            $model->icon = UploadService::getInstance()->upload($uploadData);
        }

        // \activity()->log('Changed item icon');
        $model->save();

        return $this->formatResult($model);
    }

    public function store(array $data, $uploadService)
    {
        $data['price'] = (int) preg_replace('/[^0-9]+/', '', $data['price']);
        $this->validator->validateStore($data);
        
        $model = $this->model;
        $model->name = ucwords($data["name"]);
        $model->price = $data["price"];
        $model->description = @$data["description"];
        $model->user_id= @$data["user_id"];

        $uploadData = [
            "prefix" => "item",
            "path" => Constant::ITEM_UPLOAD_PATH,
            "file" => @$data["icon"],
        ];

        $model->icon = $uploadService->upload($uploadData);
        $model->save();

        return $this->formatResult($model);
    }

    public function store_admin(array $data, $uploadService)
    {
        $this->validator->validateStore($data);

        $model = $this->model;
        $model->name = ucwords($data["name"]);
        $model->price = $data["price"];
        $model->description = @$data["description"];
        $model->is_default = 1;

        $uploadData = [
            "prefix" => "item",
            "path" => Constant::ITEM_UPLOAD_PATH,
            "file" => @$data["icon"],
        ];

        $model->icon = $uploadService->upload($uploadData);
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
        $data['price'] = (int) preg_replace('/[^0-9]+/', '', $data['price']);
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->name = ucwords($data["name"]);
        $model->price = $data["price"];
        $model->description = @$data["description"];

        if (isset($data["icon"])) {
            $uploadData = [
                "prefix" => "item",
                "path" => Constant::ITEM_UPLOAD_PATH,
                "file" => @$data["icon"],
            ];

            if ($model->icon && $model->icon != 'coin.png') {
                $uploadData["old_file"] = Constant::ITEM_UPLOAD_PATH ."/{$model->icon}";
            }

            $model->icon = $uploadService->upload($uploadData);
        }

        $model->save();

        return $this->formatResult($model);
    }

    public function deleteById(int $id, $user_id, $uploadService)
    {
        $model = $this->model->where(['id' => $id, 'user_id' => $user_id])->first();
        if (!$model) {
            throw new NotFoundException(__("message.notfound"), []);
        }
        
        // if ($model->is_default) {
        //     throw new ValidatorException(__("message.delete_item_failed"), []);
        // }

        if ($model->is_active) {
            throw new ValidatorException(__("message.delete_active_item_failed"), []);
        }

        $oldFile = Constant::ITEM_UPLOAD_PATH ."/{$model->icon}";
        $uploadService->delete($oldFile);

        return $model->delete();
    }

    public function delete($id, $uploadService)
    {
        $model = $this->model->where(['id' => $id])->first();
        if (!$model) {
            throw new NotFoundException(__("message.notfound"), []);
        }

        // if ($model->is_default) {
        //     throw new ValidatorException(__("message.delete_item_failed"), []);
        // }

        // if ($model->is_active) {
        //     throw new ValidatorException(__("message.delete_active_item_failed"), []);
        // }

        $oldFile = Constant::ITEM_UPLOAD_PATH . "/{$model->icon}";
        $uploadService->delete($oldFile);

        return $model->delete();
    }

    public function setActiveItem($userid, $id = null)
    {
        $this->model->where("user_id", $userid)->update(['is_active' => 0]);
    
        $model = $id ? $this->model->where("user_id", $userid)->find($id) : $this->model->where("user_id", $userid)->default()->oldest("price")->first();
        $model->is_active = 1;
        $model->save();

        if ($model->is_active && $this->model->where('user_id', $userid)->active()->count() > 1) {
            $model->is_active = !$model->is_active;
            $model->save();

            throw new ValidatorException(__('message.only_three_item_active'), []);
        }

        if (!$this->model->where('user_id', $userid)->active()->count()) {
            $model->is_active = !$model->is_active;
            $model->save();

            throw new ValidatorException(__('message.must_exist_one_active_item'), []);
        }

        return ["result" => $model->is_active ? __("message.item_activated") : __("message.item_inactivated")];
    }

    public function setCreatorDefaultItem($userid)
    {
        if ($this->model->where('user_id', $userid)->count()) return;

        $this->model->where('user_id', null)
                    ->get()
                    ->map(function($model) use($userid) {
                        $newModel = $model->replicate();
                        $newModel->user_id = $userid;
                        $newModel->save();

                        return $newModel;
                    });
        
        $defaultItem = $this->model->where("user_id", null)->default()->oldest('price')->first();
        $this->setActiveItem($userid);
    }

    public function getprice(int $id)
    {
        $model = $this->findById($id);
        return $model->price;
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "price" => $model->price,
            "formated_price" => Utils::toIDR($model->price),
            "description" => $model->description,
            "icon" => route("api.item.preview", ["file_name" => $model->icon ?: Constant::UNKNOWN_STATUS]),
            "is_active" => (bool) $model->is_active,
            "is_default" => (bool) $model->is_default,
            "created_at" => Utils::formatDate($model->created_at, true),
            "updated_at" => Utils::formatDate($model->updated_at, true),
        ];
    }

    public function preview($filename, $uploadService)
    {
        return $uploadService->preview(Constant::ITEM_UPLOAD_PATH ."/$filename");
    }

}