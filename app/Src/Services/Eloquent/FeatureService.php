<?php

namespace App\Src\Services\Eloquent;

use App\Models\Feature;
use App\Src\Helpers\Utils;
use App\Src\Validators\FeatureValidator;
use Illuminate\Support\Facades\Artisan;
use YlsIdeas\FeatureFlags\Facades\Features;

class FeatureService {

    protected $model;
    protected $validator;

    public function __construct(Feature $model, FeatureValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance(){
        return new static(new Feature(), new FeatureValidator());
    }

    public function getAll()
    {
        return $this->model->all();
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
        $model->title = $data["title"];
        $model->feature = $data["feature"];
        $model->description = $data["description"];
        $model->save();

        if ($data['status'] == 1 && $model->active_at == null) {
            Features::turnOn($model->feature);
        }elseif ($data['status'] == 2 && $model->active_at != null) {
            Features::turnOff($model->feature);
        }
        return $this->getReturnedValue($model);
    }

    public function editById(array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($data['id']);
        $model->title = $data["title"];
        $model->feature = $data["feature"];
        $model->description = $data["description"];
        $model->save();
        
        if ($data['status'] == 1 && $model->active_at == null) {
            // $command = 'feature:on '.$model->feature;
            // Artisan::call($command);
            Features::turnOn($model->feature);
        }elseif ($data['status'] == 2 && $model->active_at != null) {
            // $command = 'feature:off '.$model->feature;
            // Artisan::call($command);
            Features::turnOff($model->feature);
        }
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
                            ->addColumn('actions', function($row) {
                                $actions = Utils::getActionFor("edit", null, 'onclick="edit(this)"', ['id' => $row['id']]);
                                $actions .= Utils::getActionFor("delete", null, 'onclick="deleteConfirm(this)"', ['id' => $row['id']]);
            
                                return $actions;
                            })
                            ->addColumn('status', function($row) {
                                $status = $row['active_at'] == null ? '<span class="badge badge-pill bg-warning">Inactive</span>' : '<span class="badge badge-pill bg-success">Active</span>';
                                return $status;
                            })
                            ->rawColumns(['actions', 'status'])
                            ->toJson();
    }

    public function setstatus($id)
    {
        $model = $this->findById($id);
        $command = "";
        if ($model->active_at === null) {
            $command = "feature:on ".$model->feature;
        }else{
            $command = "feature:off ".$model->feature;
        }
        $artisan = Artisan::call($command);
        return $artisan;
    }



    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "title" => $model->title,
            "feature" => $model->feature,
            "description" => $model->description,
            "active_at" => $model->active_at,
        ];
    }
}