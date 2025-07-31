<?php

namespace App\Src\Services\Eloquent;

use App\Models\Report;
use App\Src\Exceptions\ValidatorException;
use App\Src\Validators\ReportValidator;
use App\Src\Helpers\Constant;
use Illuminate\Support\Facades\View;

class ReportService {

    protected $model;
    protected $validator;

    public function __construct(Report $model, ReportValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance(){
        return new static(new Report(), new ReportValidator());
    }

    public function store(array $data, $uploadService)
    {
        // dd(json_encode($data['category']));
        $this->validator->validateStore($data);
        $model = $this->model;
        $model->name = $data["name"];
        $model->email = $data["email"];
        $model->link = $data["link"];
        $model->type = $data["type"];
        $model->creator_id = @$data["creator_id"];
        $model->content_id = @$data["content_id"];
        $model->category = json_encode($data["category"]);
        $model->description = $data["description"];
        $uploadData = [
            "prefix" => "screenshot",
            "path" => Constant::REPORT_SCREENSHOT_PATH,
            "file" => $data["screenshot"],
        ];

        $model->screenshot = $uploadService->upload($uploadData);
        $model->save();

        return $this->formatResult($model);
    }

    // public function getlist($status)
    // {
    //     $model = $this->model;                
    //             if (isset($status)) {
    //                 $model = $model->where('status', $status);
    //             }
    //             $model = $model->get()
    //                     ->map(function($model) {
    //                         return $this->formatResult($model);
    //                     });
    //     return $model;
    // }

    public function getlist($status, $type)
    {
        $query = $this->model->where('type', $type)
                            ->where('status', $status)->get()
                        ->map(function($model) {
                            return $this->formatResult($model);
                        });
        
        return datatables()->of($query)
                            ->addIndexColumn()
                            ->editColumn('link', function($row) {
                                return '<a href="'.$row['link'].'" target="_blank"><i class="ri-external-link-line"></i></a>';
                            })
                            ->editColumn('screenshot', function($row) {
                                return '<a href="#" data-src="'. $row['screenshot'] .'" onclick="preview(this)"><img src="'. $row['screenshot'] .'" alt="profile-img"  class="img-fluid rounded" style="width: 90px; height: 90px;"></a>';
                            })
                            ->editColumn('category', function($row) {
                                // dd(json_decode($row['category']));
                                return View::make('components.report-category', ['category' => json_decode($row['category'])]);
                            })
                            ->addColumn('action', function ($row) use ($type) {
                                if ($type=='creator') {
                                    $actions = '<a href="#" type="button" data-id="' . $row['id'] . '" onclick="Suspend(this)" class="btn btn-outline-primary mb-1"><i class="las la-eye-slash"></i> Suspend</a>';
                                    $actions .= '<a href="#" type="button" data-id="' . $row['id'] . '" onclick="Unsuspend(this)" class="btn btn-outline-primary mb-1"><i class="las la-eye"></i> Unsuspend</a>';
                                    $actions .= '<a href="#" type="button" data-id="' . $row['id'] . '" onclick="setDone(this)" class="btn btn-outline-primary mb-1"><i class="las la-check-circle"></i> Set Done</a>';
                                } else {
                                    $actions = '<a href="#" type="button" data-id="' . $row['id'] . '" onclick="Block(this)" class="btn btn-outline-primary mb-1"><i class="las la-eye-slash"></i> Block</a>';
                                    $actions .= '<a href="#" type="button" data-id="' . $row['id'] . '" onclick="Unblock(this)" class="btn btn-outline-primary mb-1"><i class="las la-eye"></i> Unblock</a>';
                                    $actions .= '<a href="#" type="button" data-id="' . $row['id'] . '" onclick="setDone(this)" class="btn btn-outline-primary mb-1"><i class="las la-check-circle"></i> Set Done</a>';
                                }
                                
                                
                                return $actions;
                            })
                            ->rawColumns(['link', 'screenshot', 'action'])
                            ->toJson();
    }
    
    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function getDetail(int $id)
    {
        $model = $this->findById($id);

        return $this->formatResult($model);
    }

    public function setstatus(array $data)
    {
        $model = $this->findById($data['id']);
        $model->status = $data['status'];
        $model->save();
        return ["result" => __("message.report_status")];
    }

    public function suspend(int $id)
    {
        $check = UserService::getInstance()->findById($id);
        // dd($check->creator_id);
        if ($check->id != null) {
            return UserService::getInstance()->suspend($check->id);
        }else{
            throw new ValidatorException(__('Creator ID not found <a href="'.route('admin.creator.list.index').'" type="button"> Open Creator List</a>'), []);
        }
    }

    public function unsuspend(int $id)
    {
        $check = UserService::getInstance()->findById($id);
        // dd($check->creator_id);
        if ($check->id != null) {
            return UserService::getInstance()->unsuspend($check->id);
        } else {
            throw new ValidatorException(__('Creator ID not found <a href="'.route('admin.creator.list.index').'" type="button"> Open Creator List</a>'), []);
        }
    }

    public function block(int $id)
    {
        $check = $this->findById($id);
        // dd($check->creator_id);
        if ($check->content_id != null) {
            return ContentService::getInstance()->block($check->content_id);
        }else{
            throw new ValidatorException(__('Content ID not found <a href="'.route('admin.creator.list.index').'" type="button"> Open Content List</a>'), []);
        }
    }

    public function unblock(int $id)
    {
        $check = $this->findById($id);
        // dd($check->creator_id);
        if ($check->content_id != null) {
            return ContentService::getInstance()->unblock($check->content_id);
        } else {
            throw new ValidatorException(__('Content ID not found <a href="'.route('admin.creator.list.index').'" type="button"> Open Content List</a>'), []);
        }
    }

    public function preview($filename, $uploadService)
    {
        return $uploadService->preview(Constant::REPORT_SCREENSHOT_PATH ."/$filename");
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "email" => $model->email,
            "link" => $model->link,
            "category" => $model->category,
            "description" => $model->description,
            "status" => Constant::getReportStatus($model->status),
            "screenshot" => route("api.report.preview", ["file_name" => $model->screenshot ?: Constant::UNKNOWN_STATUS]),
            "created_at" => $model->created_at->format("d-m-Y H:i:s"),
        ];
    }
}
