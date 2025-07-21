<?php

namespace App\Src\Services\Eloquent;

use App\Models\PayoutChannel;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use App\Src\Validators\PayoutChannelValidator;

class PayoutChannelService {

    protected $model;
    protected $validator;

    public function __construct(PayoutChannel $model, PayoutChannelValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance(){
        return new static(new PayoutChannel(), new PayoutChannelValidator());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getChannel()
    {
        return [
            "ewallet" => $this->model->where('type', 1)->get(),
            "bank" => $this->model->where('type', 2)->get()
        ];
    }

    public function getById(int $id)
    {
        $model = $this->findById($id);

        return $this->getReturnedValue($model);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function store(array $data)
    {
        $this->validator->validateStore($data);
        $model = $this->model;
        $model->title = strtoupper($data["title"]);
        $model->channel_code = strtolower($data["channel_code"]);
        $model->type = $data["type"];
        $model->save();

        return $this->getReturnedValue($model);
    }

    public function editById(array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($data['id']);
        $model->title = strtoupper($data["title"]);
        $model->channel_code = strtolower($data["channel_code"]);
        $model->type = $data["type"];
        $model->save();
        return $this->getReturnedValue($model);
    }

    public function deleteById($id)
    {
        $model = $this->findById($id);
        return $model->delete();
    }

    public function dtListCategory()
    {
        $query = $this->model->get();

        return datatables()->of($query)
                            ->addIndexColumn()
                            ->editColumn('type', function($row) {
                                return Constant::getPayoutType($row->type);
                            })
                            ->addColumn('actions', function($row) {
                                $actions = Utils::getActionFor("edit", null, 'onclick="edit(this)"', ['id' => $row['id']]);
                                $actions .= Utils::getActionFor("delete", null, 'onclick="deleteConfirm(this)"', ['id' => $row['id']]);
            
                                return $actions;
                            })
                            ->rawColumns(['actions'])
                            ->toJson();
    }

    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "title" => $model->title,
            "channel_code" => $model->channel_code,
            "type" => $model->type,
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }
}