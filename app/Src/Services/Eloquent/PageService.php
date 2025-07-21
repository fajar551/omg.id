<?php

namespace App\Src\Services\Eloquent;

use App\Models\Page;
use App\Src\Base\IBaseService;
use App\Src\Helpers\Constant;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\PageValidator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Page $model, PageValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new Page(), new PageValidator());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getPage(String $page_url, String $supporter_id = null)
    {
        $this->validator->validatePageurl($page_url);
        $model = $this->model->where("page_url", $page_url)->first();
        return $this->formatResult($model, ['supporter_id' => $supporter_id]);
    }

    public function validatePageurl(String $page_url)
    {
        return $this->validator->validatePageurl($page_url);
    }

    public function getDataTable(int $id, array $params = [])
    {
        $query = $this->getPage($id);

        return datatables()->of($query)
                ->addColumn('creator', function($row) {
                    return $row->user->name;
                })
                ->editColumn('pinned', function($row) {
                    return (bool) $row->pinned;
                })
                ->editColumn('post_image', function($row) {
                    return route("api.post.preview", ["file_name" => $row->post_image ?: Constant::UNKNOWN_STATUS]);
                })
                ->editColumn('status', function($row) {
                    return Constant::getPostStatus($row->status);
                })
                ->orderColumn('creator', function($query, $order) {
                    // TODO: Change order by to name of user instead of id_user
                    $query->orderBy('user_id', $order);
                })
                ->rawColumns([])
                ->toJson();
    }

    public function getDetail(int $id)
    {
        $model = $this->findById($id);

        return $this->formatResult($model);
    }

    public function getByUserId(int $user_id)
    {
        $model = $this->model->where("user_id", $user_id)->first();

        return $this->formatResult($model);
    }

    public function store(array $data)
    {
        $this->validator->validateStore($data);
        
        if ($this->model->where('user_id', $data["user_id"])->count()) return;

        $model = $this->model;
        $model->user_id= $data["user_id"];
        $model->page_url = $data["page_url"];
        $model->category_id= @$data["category_id"];
        $model->template_id= @$data["template_id"] ?? Constant::DEFAULT_TEMPLATE;
        $model->name = @$data["name"];
        $model->page_message = @$data["page_message"];
        $model->status = @$data["status"] ?? 0;

        $model->save();

        return $this->formatResult($model);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function setProfile(int $id, array $data, UploadService $uploadService)
    {
        $this->validator->validateProfile($data);

        $model = $this->findById($id);
        $model->bio = @$data["bio"];
        $model->page_url = $data["page_url"];
        $model->name = $data["name"];
        $model->page_message = $data["page_message"];
        $model->category_id = $data["category_id"];


        $model->save();

        return $this->formatResult($model);
    }

    public function deleteById(int $id, UploadService $uploadService)
    {
        $model = $this->findById($id);

        // Delete post file
        $oldFile = Constant::PAGE_COVER_PATH ."/{$model->cover_image}";
        $uploadService->delete($oldFile);

        return $model->delete();
    }

    public function setVideo(int $id, $video)
    {
        $this->validator->validateVideo(['id' => $id, 'video' => $video]);
        
        $model = $this->findById($id);
        $model->video = null;
        if ($video) {
            $cek = strpos($video, "=");
            if($cek){
                $string = explode("=",$video);
                $url = array_pop($string);
            }else{
                $string = explode("/",$video);
                $url = array_pop($string);
            }

            $model->video = "https://www.youtube.com/embed/".$url;
        }

        $model->save();

        return [
            "id" => $model->id,
            "video" => $model->video,
        ];
    }

    public function setSummary(int $id, $summary)
    {
        $model = $this->findById($id);
        $model->summary = $summary;
        $model->save();

        return [
            "id" => $model->id,
            "summary" => $model->summary,
        ];
    }

    public function setCategory(int $id, int $category_id)
    {
        $model = $this->findById($id);
        $model->category_id= $category_id;
        $model->save();

        return [
            "id" => $model->id,
            "category_id" => $model->category_id,
        ];
    }

    public function setCover(array $data, $id, UploadService $uploadService)
    {
        $model = $this->findById($id);
        if (isset($data["cover_image"])) {
            // dd($data["cover_image"]);
            $image_parts = explode(";base64,", $data["cover_image"]);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $cover_image = uniqid() . '.'. $image_type;
            $file = Constant::PAGE_COVER_PATH . '/' . $cover_image;
            Storage::disk()->put($file, $image_base64);

            // dd([$image_base64, $file]);
            // $uploadData = [
            //     "prefix" => "cover_image",
            //     "path" => Constant::PAGE_COVER_PATH,
            //     "file" => @$image_base64,
            // ];

            if ($model->cover_image) {
                Storage::disk()->delete(Constant::PAGE_COVER_PATH ."/{$model->cover_image}");
            }

            $model->cover_image = $cover_image;
        }
        $model->save();

        return [
            "id" => $model->id,
            "cover_image" => route("api.pagecover.preview", ["file_name" => $model->cover_image ?: Constant::UNKNOWN_STATUS]),
        ];
    }

    public function setfeatured(int $id)
    {
        $model = $this->findById($id);
        if ($model->featured == 1) {
            $model->featured = 0;
        }else{
            $model->featured = 1;
        }
        
        
        return $model->save();
    }

    public function setpicked(int $id)
    {
        $model = $this->findById($id);
        if ($model->editor_pick == 1) {
            $model->editor_pick = 0;
        } else {
            $model->editor_pick = 1;
        }

        $model->save();
        return $model->save();
    }

    public function setsensitive(int $id)
    {
        $model = $this->findById($id);
        if ($model->sensitive_content == 1) {
            $model->sensitive_content = 0;
        } else {
            $model->sensitive_content = 1;
        }

        $model->save();
        return $model->save();
    }

    public function setstatus(int $id)
    {
        $model = $this->findById($id);
        if ($model->status == 1) {
            $model->status = 0;
        } else {
            $model->status = 1;
        }

        $model->save();
        return $model->save();
    }

    public function formatResult($model, array $params = [])
    {
        $followerService = FollowersService::getInstance();

        return [
            "id" => $model->id,
            "name" => $model->name,
            "user_id" => $model->user_id,
            "follow_detail" => $followerService->getFollowInfo($model->user_id, false, @$params['supporter_id']),
            "bio" => $model->bio,
            "page_url" => $model->page_url,
            "page_message" => $model->page_message,
            "cover_image" => route("api.pagecover.preview", ["file_name" => $model->cover_image ?: Constant::UNKNOWN_STATUS]),
            "avatar" => route("api.profile.preview", ["file_name" => $model->user->profile_picture ?: Constant::UNKNOWN_STATUS]),
            "video" => $model->video,
            "summary" => $model->summary,
            "category_id" => $model->category_id,
            "category" => $model->category,
        ];
    }

    public function preview($filename, UploadService $uploadService)
    {
        return $uploadService->preview(Constant::PAGE_COVER_PATH ."/$filename", public_path("template/images/bg-gradient.png"));
    }

    public function previewavatar($filename, UploadService $uploadService)
    {
        return $uploadService->preview(Constant::PAGE_AVATAR_PATH . "/$filename", public_path("template/images/user/user.png"));
    }

}