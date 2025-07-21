<?php

namespace App\Src\Services\Eloquent;

use App\Models\Comment;
use App\Models\Content;
use App\Src\Base\IBaseService;
use App\Src\Helpers\Constant;
use App\Src\Helpers\UploadPath;
use App\Src\Services\Eloquent\CommentService;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\CommentValidator;
use App\Src\Validators\ContentValidator;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;
use File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Content $model, ContentValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Get the instance of class.
     *
     * @return object
     */
    public static function getInstance()
    {
        return new static(new Content(), new ContentValidator());
    }

    /**
     * Get formated or customize result from a model.
     *
     * @return array
     */
    public function formatResult($model) 
    {
        return $model->toArray();
    }

    /**
     * Get all of model data.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->model->all();
    }
    
    /**
     * Get the content by user_id.
     *
     * @param int $user_id
     * @return array
     */
    public function userContents(int $user_id)
    {
        $query = $this->model->where("user_id", $user_id)
                    ->with('category')
                    ->latest()
                    ->paginate(10);

        return [
            'meta' => $resource = new JsonResource($query),
            'contents' => $resource->collection($query),
        ];
    }

    /**
     * Retrieve a model.
     *
     * @param int $id
     * @return object
     */
    public function show(int $id)
    {
        $this->validator->validateContentID($id);

        return $this->model->find($id);
    }

    /**
     * Retrieve a model.
     *
     * @param array $data
     * @return object
     */
    public function showUserContent(array $data)
    {
        $this->validator->validateContentWithUserID($data);

        $model = $this->model->where([
            'user_id' => $data['user_id']
        ])->find($data['id']);

        if (!$model) {
            throw new NotFoundHttpException(__('message.notfound'), null, 404);
        }

        return $model;
    }

    /**
     * Create a new data.
     *
     * @param array $data
     * @return array
     */
    public function store2(array $data)
    {
        $this->validator->validateStore2($data);
        
        $model = $this->model;
        $model->user_id = $data['user_id'];
        $model->title = ucwords($data["title"]);
        $model->category_id= @$data["category_id"];
        $model->item_id = @$data["qty"] && $data["qty"] > 0 ? @$data["item_id"] : null;
        $model->qty = @$data["qty"];
        $model->external_link = @$data["external_link"];
        $model->status = $data["status"];
        $model->sensitive_content = @$data["sensitive_content"] && $data["sensitive_content"] == 1 ? 1 : 0;
        $model->save();
        
        // Handle image upload (Editor.js block body)
        $body = $this->handleContentBody(json_decode($data["body"]), ['id' => $model->id]);
        $model->body = $body;
        $model->save();

        // Delete other uploaded temporary file from public/uploads/temp directory
        // This file is included in block body editor.js
        $tempUploadedImage = json_decode($data['tempUploadedImage']);
        if (count($tempUploadedImage)) {
            $tempImagePath = public_path("uploads/temp/");
            foreach ($tempUploadedImage as $image) {
                if (File::exists($file = "$tempImagePath/$image")) {                        
                    File::delete($file);
                }
            }
        }

        $uploadService = UploadService::getInstance();
        // Upload thumbnail
        if (@$data['thumbnail']) {
            $config = [
                "prefix" => "thumb",
                "path" => UploadPath::content($model->id),
                "file" => $data["thumbnail"],
            ];
    
            $model->thumbnail = $uploadService->upload($config);
            $model->save();
        }

        // Upload cover image / The cover use thumbnail instead
        if (@$data['cover_image']) {
            $config = [
                "prefix" => "cover",
                "path" => UploadPath::content($model->id),
                "file" => $data["cover_image"],
            ];
    
            $model->cover_image = $uploadService->upload($config);
            $model->save();
        }

        // Upload attachment file
        if (@$data["attachment"]) {
            $uploadDataFile = [
                "prefix" => "attachment",
                "path" => UploadPath::content($model->id),
                "file" => @$data["attachment"],
            ];
    
            $model->file = $uploadService->upload($uploadDataFile);
            $model->save();
        }

        return $model;
    }

    /**
     * Create a new data.
     *
     * @param array $data
     * @return array
     */
    public function update(array $data)
    {
        $this->validator->validateUpdate2($data);
        
        $model = $this->model->where(['user_id' => $data['user_id']])->find($data['id']);
        if (!$model) {
            throw new NotFoundHttpException(__('message.notfound'), null, 404);
        }

        $model->title = ucwords($data["title"]);
        $model->category_id = @$data["category_id"];
        $model->item_id = @$data["qty"] && $data["qty"] > 0 ? @$data["item_id"] : null;
        $model->qty = @$data["qty"];
        $model->external_link = @$data["external_link"];
        $model->status = $data["status"];
        $model->sensitive_content = @$data["sensitive_content"] && $data["sensitive_content"] == 1 ? 1 : 0;
        $model->save();

        // Handle image upload (Editor.js block body)
        $body = $this->handleContentBody(json_decode($data["body"]), ['id' => $model->id]);
        $model->body = $body;
        $model->save();

        // Delete other uploaded temporary file from public/uploads/temp directory
        // This file is included in block body editor.js
        $tempUploadedImage = json_decode($data['tempUploadedImage']);
        if (count($tempUploadedImage)) {
            $tempImagePath = public_path("uploads/temp/");
            foreach ($tempUploadedImage as $image) {
                if (File::exists($file = "$tempImagePath/$image")) {                        
                    File::delete($file);
                }
            }
        }
        
        $uploadService = UploadService::getInstance();

        // Upload thumbnail
        if (@$data['thumbnail']) {
            $config = [
                "prefix" => "thumb",
                "path" => UploadPath::content($model->id),
                "file" => $data["thumbnail"],
            ];
    
            if ($model->thumbnail) {
                $config["old_file"] = UploadPath::content("$model->id/$model->thumbnail");
            }

            $model->thumbnail = $uploadService->upload($config);
            $model->save();
        }

        // Upload cover image
        if (@$data['cover_image']) {
            $config = [
                "prefix" => "cover",
                "path" => UploadPath::content($model->id),
                "file" => $data["cover_image"],
            ];
    
            if ($model->cover_image) {
                $config["old_file"] = UploadPath::content("$model->id/$model->cover_image");
            }

            $model->cover_image = $uploadService->upload($config);
            $model->save();
        }

        // Upload attachment file
        if (@$data["attachment"]) {
            $config = [
                "prefix" => "attachment",
                "path" => UploadPath::content($model->id),
                "file" => @$data["attachment"],
            ];

            if ($model->file) {
                $config["old_file"] = UploadPath::content("$model->id/$model->file");
            }
    
            $model->file = $uploadService->upload($config);
            $model->save();
        }

        return $model;
    }

    /**
     * Handle block body for editor js.
     *
     * @param object $body 
     * @param array $param
     * @return object $body
     */
    public function handleContentBody($body, array $param)
    {
        $content_id = $param['id'];

        foreach ($body->blocks as $block) {
            if ($block->type == 'image') {
                $dataBlock = $block->data; 
                $url = $dataBlock->file->url;
                $url = parse_url($url);
                
                if (@$url['path']) {
                    // $tempImagePath = public_path($url['path']);
                    $fileName = @$dataBlock->file->fileName;
                    $tempImagePath = public_path("uploads/temp/$fileName");
                    
                    if ($fileName && File::exists($tempImagePath)) {                        
                        $uploadDirectory = storage_path("app/uploads/content/{$content_id}");

                        // Check if directory exist
                        if (!File::isDirectory($uploadDirectory)) {
                            File::makeDirectory($uploadDirectory);
                        }
                        
                        // Move file from public/uploads/temp directory to file storage
                        File::move($tempImagePath, "$uploadDirectory/$fileName");

                        // Delete temp file
                        File::delete($tempImagePath);

                        // Assign new moved file to data block
                        $dataBlock->file->url = asset("uploads/content/{$content_id}/{$fileName}");
                    }
                }
            }
        }

        return $body;
    }

    /**
     * Download the file attachment.
     *
     * @param array $data 
     * @return \Illuminate\Support\Facades\Storage
     */
    public function download(array $data)
    {
        $model = $this->model->where([
            'user_id' => $data['user_id']
        ])->find($data['id']);

        if (!$model) {
            throw new NotFoundHttpException(__('message.notfound'), null, 404);
        }

        return \Storage::download(UploadPath::content("$model->id/$model->file"));
    }

    /**
     * Delete an existing data.
     *
     * @param array $data
     * @return bool
     */
    public function delete(array $data)
    {
        $this->validator->validateContentWithUserID($data);

        $model = $this->model->where([
            'user_id' => $data['user_id']
        ])->find($data['id']);

        if (!$model) {
            throw new NotFoundHttpException(__('message.notfound'), null, 404);
        }

        \Storage::deleteDirectory(UploadPath::content($model->id));

        return $model->delete();
    }

    /**
     * Get detail of contents.
     *
     * @param array $data
     * @return void
     */
    public function detail(array $data)
    {
        $this->validator->validateContentID($data['content_id']);

        $query = $this->model
                        ->select('id', 'user_id', 'category_id', 'title', 'body', 'status', 'thumbnail', 'qty', 'file', 'external_link', 'created_at', 'updated_at')
                        ->when($data['supporter_id'], function ($q) {
                            $q->with([
                                // 'comments' => function($q) {
                                //     $q->withCount(['likes'])->latest()->take(5);
                                // },
                                // 'comments.user' => function ($q) {
                                //     $q->select('id', 'name', 'username', 'profile_picture');
                                // },
                                // 'comments.likes.user' => function ($q) {
                                //     $q->select('id', 'name', 'profile_picture')->take(10);
                                // },
                                'category' => function ($q) {
                                    $q->select('id', 'title');
                                },
                            ]);
                        })
                        ->withCount(['comments', 'likes', 'subscribe'])
                        ->latest()
                        ->find($data['content_id']);

        // If supporter_id == query->user_id it's mean the owner of content
        if ($data['supporter_id'] == $query->user_id) {
            return [
                'access' => true,
                'content' => $query,
            ];
        }

        // If content quantity is zero and status is published (1) and supporter_id null, 
        // it's mean free content and published content and user is not logged
        if ($query->qty == 0 && $query->status == 1 && $data['supporter_id'] == null) {
            return [
                'access' => false,
                'message' => __("message.content_no_access"),
                'content' => $query,
            ];
        }

        // If content quantity is zero and status is published (1) and supporter_id not null, 
        // it's mean free content and published content and user is logged in
        if ($query->qty == 0 && $query->status == 1 && $data['supporter_id'] != null) {
            return [
                'access' => true,
                'content' => $query,
            ];
        }
        
        // If content qty > 0 and status is published (1) and supporter_id not null, it's mean paid content
        if ($query->qty > 0 && $query->status == 1 && $data['supporter_id'] != null) {
            $akses = ContentSubscribeService::getInstance()->checkaccess($data['supporter_id'], $data['content_id']);
            
            if (!$akses) {
                return [
                    'access' => false,
                    'content' => $query,
                    'message' => __("message.content_no_access"),
                ];
            } 

            return [
                'access' => true,
                'content' => $query,
            ];
        }

        return [
            'access' => false,
            'content' => $query,
            'message' => __("message.content_no_access"),
        ];
    }

    /**
     * Get random or related of contents.
     *
     * @param array $data
     * @return void
     */
    public function relatedContent(array $data)
    {
        return $this->model->inRandomOrder()
                        ->where('status', 1)
                        ->when(@$data['supporter_id'], function($q) use($data) {
                            $q->where('user_id', '!=', $data['supporter_id']);
                        })
                        ->limit(5)
                        ->get();
    }

    public function getContents(int $id)
    {
        $query = $this->model->where("user_id", $id);
        return datatables()->of($query)
                ->editColumn('thumbnail', function($row) {
                    return route("api.contentthumbnail.preview", ["file_name" => $row->thumbnail ?: Constant::UNKNOWN_STATUS]);
                })
                ->editColumn('cover_image', function($row) {
                    return route("api.contentcover.preview", ["file_name" => $row->cover_image ?: Constant::UNKNOWN_STATUS]);
                })
                ->editColumn('status', function($row) {
                    return Constant::getPostStatus($row->status);
                })
                ->editColumn('sensitive_content', function($row) {
                    return (bool) $row->sensitive_content;
                })
                ->rawColumns([])
                ->toJson();
    }

    public function getPublished(int $id, $title, $limit = null, $supporter_id = null, $order = null, $page = null, $slug = null)
    {
        $query = [];
        $no = 0;
        $param=array('user_id'=> $id, 'title'=>$title);
        $content = $this->model
                    ->where(["user_id" => $id, "status" => 1])
                    ->when((@$param['title'] && $param['title'] != 'all'), function($q) use ($param) {
                        $q->whereHas('category', function ($q) use ($param) {
                            $q->where(array('title' => $param['title'], 'user_id'=>$param['user_id']));
                        });
                    })
                    ->when((@$slug), function ($q) use ($slug) {
                        $q->where(array('id' => (int) $slug));
                    });

        if ($order == 'oldest') {
            $content = $content->orderBy('created_at', 'asc');
        }elseif ($order == 'asc') {
            $content = $content->orderBy('title', 'asc');
        }elseif ($order == 'desc') {
            $content = $content->orderBy('title', 'desc');
        }else {
            $content = $content->latest();
        }

        $content = $content->paginate($limit ?? 10, ['*'], 'page',$page);
        $meta_data = [
            "current_page" => $content->currentPage(),
            "last_page" =>  $content->lastPage(),
            "per_page" => $content->perPage(),
            "total_page" => $content->total(),
            "next_page_url" => $content->nextPageUrl(),
            "links" => (string) $content->links(),
        ];

        if (isset($supporter_id)) {
            foreach ($content as $key) {
                $akses = ContentSubscribeService::getInstance()->checkaccess($supporter_id, $key->id);
                
                $query[$no] = $this->getReturnedValue($key);
                if ($akses!=null && $key->qty != 0) {
                    $query[$no]['akses'] = 'Paid';
                }else{
                    if ($key->qty == 0) {
                        $query[$no]['akses'] = 'Free';
                    }else{
                        $query[$no]['akses'] = 'Unpaid';
                    }
                }
                $no++;
            }
        } else {
            $query = $content->map(function ($model) {
                return $this->getReturnedValue($model);
            });
        }

        return ['data' => $query, "pagging" => $meta_data];
    }

    public function getSubscribed(int $id, $title, $limit = null, $supporter_id = null, $order = null)
    {
        $query = [];
        $no = 0;
        $param=array('user_id'=> $id, 'title'=>$title);
        $content = $this->model
                    ->where("user_id", $id)
                    ->where("status", 1)
                    ->whereHas(
                        'category', function ($q) use ($param){
                            if (isset($param['title'])) {
                                $q->where(array('title' => $param['title'], 'user_id'=>$param['user_id']));
                            }
                        }
                    );
                    if ($order == 'oldest') {
                        $content = $content->orderBy('created_at', 'asc');
                    }elseif ($order == 'asc') {
                        $content = $content->orderBy('title', 'asc');
                    }elseif ($order == 'desc') {
                        $content = $content->orderBy('title', 'desc');
                    }else {
                        $content = $content->latest();
                    }
                    $content = $content->paginate($limit ?? 10);
                    $meta_data = [
                        "current_page" => $content->currentPage(),
                        "last_page" =>  $content->lastPage(),
                        "per_page" => $content->perPage(),
                        "total_page" => $content->total(),
                        "next_page_url" => $content->nextPageUrl(),
                        "links" => (string) $content->links(),
                    ];


                    if (isset($supporter_id)) {
                        foreach ($content as $key) {
                            $akses = ContentSubscribeService::getInstance()->checkaccess($supporter_id, $key->id);
                            
                            if ($akses!=null && $key->qty != 0) {
                                $query[$no] = $this->getReturnedValue($key);
                                $query[$no]['akses'] = 'Paid';
                            }
                            $no++;
                        }
                    }

        return ['data' => $query, "pagging" => $meta_data];
    }

    public function getPublishedLoged(int $id, int $supporter_id, $title)
    {
        $query = [];
        $no = 0;
        $param=array('user_id'=> $id, 'title'=>$title);
        $content = $this->model
                    ->where("user_id", $id)
                    ->where("status", 1)
                    ->whereHas(
                        'category', function ($q) use ($param){
                            if (isset($param['title'])) {
                                $q->where(array('title' => $param['title'], 'user_id'=>$param['user_id']));
                            }
                        }
                    )
                    ->latest()
                    ->paginate(10);
        foreach ($content as $key) {
            $akses = ContentSubscribeService::getInstance()->checkaccess($supporter_id, $key->id);
            
            $query[$no] = $this->getReturnedValue($key);
            if ($akses!=null && $key->qty != 0) {
                $query[$no]['akses'] = 'Paid';
            }else{
                if ($key->qty == 0) {
                    $query[$no]['akses'] = 'Free';
                }else{
                    $query[$no]['akses'] = 'Unpaid';
                }                
            }
            $no++;
        }
        return $query;
    }

    /**
     * Get detail of contents.
     *
     * @deprecated use detail instead
     * @param int $content_id, 
     * @param int $supporter_id
     * @return array
     */
    public function getDetail(int $content_id, int $supporter_id)
    {
        $this->validator->validateId($content_id);
        $akses = ContentSubscribeService::getInstance()->checkaccess($supporter_id, $content_id);
        $query = $this->model->where("id", $content_id)
                    ->with([
                        "comments" => function($q) {
                            $q->oldest();
                        },
                    ])
                    ->latest()
                    ->first();
                    $data["comments"] = $query->comments->map(function($model) {
                            return CommentService::getInstance()->formatResult($model);
                        });
                    // ->map(function ($model) {
                        // $data["comments"] = $model->comments->map(function($model) {
                        //     return (new CommentService(new Comment(), new CommentValidator()))->formatResult($model);
                        // });

                        // return array_merge($data, $this->getReturnedValue($model) );
                    // });
                    
        if ($akses == null && $query->qty != 0) {
            return "You have no access to this content";
        }
        
        return array_merge($data, $this->getReturnedValue($query) );
    }

    /**
     * @deprecated use store2 instead
     */
    public function store(int $user_id, array $data, UploadService $uploadService)
    {
        $data["user_id"] = $user_id;
        $this->validator->validateStore($data);
        
        $model = $this->model;
        $model->user_id= $user_id;
        $model->title = ucwords($data["title"]);
        $model->content = $data["content"];
        $model->category_id= $data["category_id"];
        $model->item_id = @$data["item_id"];
        $model->qty = @$data["qty"];
        $model->external_link = @$data["external_link"];
        $model->status = $data["status"];
        $model->sensitive_content = @$data["sensitive_content"];

        
        $uploadDataThumbnail = [
            "prefix" => "thumbnail",
            "path" => Constant::CONTENT_THUMBNAIL_PATH,
            "file" => $data["thumbnail"],
        ];

        $model->thumbnail = $uploadService->upload($uploadDataThumbnail);

        $uploadDataCoverImage = [
            "prefix" => "cover_image",
            "path" => Constant::CONTENT_COVER_IMAGE_PATH,
            "file" => @$data["cover_image"],
        ];

        $model->cover_image = $uploadService->upload($uploadDataCoverImage);

        $uploadDataFile = [
            "prefix" => "file",
            "path" => Constant::CONTENT_FILE_PATH,
            "file" => @$data["file"],
        ];

        $model->file = $uploadService->upload($uploadDataFile);
        $model->save();

        return $this->getReturnedValue($model);
    }

    /**
     * @deprecated use show instead
     */
    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    /**
     * @deprecated use update instead
     */
    public function editById(int $id, array $data, UploadService $uploadService)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->title = ucwords($data["title"]);
        $model->content = $data["content"];
        $model->category_id= $data["category_id"];
        $model->item_id = @$data["item_id"];
        $model->qty = @$data["qty"];
        $model->external_link = @$data["external_link"];
        $model->status = $data["status"];
        $model->sensitive_content = @$data["sensitive_content"];

        if(isset($data["thumbnail"])){
            $uploadDataThumbnail = [
                "prefix" => "thumbnail",
                "path" => Constant::CONTENT_THUMBNAIL_PATH,
                "file" => @$data["thumbnail"],
            ];
    
            if ($model->thumbnail) {
                $oldFile = Constant::CONTENT_THUMBNAIL_PATH ."/{$model->thumbnail}";
                $uploadService->delete($oldFile);
            }

            $model->thumbnail = $uploadService->upload($uploadDataThumbnail);
        }
        
        if (isset($data["cover_image"])) {
            $uploadDataCoverImage = [
                "prefix" => "cover_image",
                "path" => Constant::CONTENT_COVER_IMAGE_PATH,
                "file" => @$data["cover_image"],
            ];
    
            if ($model->cover_image) {
                $oldFile = Constant::CONTENT_COVER_IMAGE_PATH ."/{$model->cover_image}";
                $uploadService->delete($oldFile);
            }
    
            $model->thumbnail = $uploadService->upload($uploadDataCoverImage);
        }
        
        if (isset($data["file"])) {
            $uploadDataFile = [
                "prefix" => "file",
                "path" => Constant::CONTENT_FILE_PATH,
                "file" => @$data["file"],
            ];
    
            if ($model->file) {
                $oldFile = Constant::CONTENT_FILE_PATH ."/{$model->file}";
                $uploadService->delete($oldFile);
            }
    
            $model->file = $uploadService->upload($uploadDataFile);
        }
        
        $model->save();

        return $this->getReturnedValue($model);
    }
    
    /**
     * @deprecated use delete instead
     */
    public function deleteById(int $id, UploadService $uploadService)
    {
        $model = $this->findById($id);

        // Delete post file
        $oldFile = Constant::CONTENT_THUMBNAIL_PATH ."/{$model->thumbnail}";
        $uploadService->delete($oldFile);
        $oldFile = Constant::CONTENT_COVER_IMAGE_PATH ."/{$model->file}";
        $uploadService->delete($oldFile);
        $oldFile = Constant::CONTENT_FILE_PATH ."/{$model->file}";
        $uploadService->delete($oldFile);

        return $model->delete();
    }

    public function setCategory(int $id, int $category_id)
    {
        $model = $this->findById($id);
        $model->category_id = $category_id;
        $model->save();

        return [
            "id" => $model->id,
            "title" => $model->title,
            "category_id" => $model->category_id,
        ];
    }

    /**
     * Set the status of content to Draft or Publish
     * 
     * @param  int $id
     * @param  int $status | 0 = Draft; 1 = Publish
     * @return array
     */
    public function setStatus(int $id, int $status)
    {
        $model = $this->show($id);
        $model->status = $status;
        $model->save();

        return [
            "id" => $model->id,
            "title" => $model->title,
            "status" => Constant::CONTENT_STATUS[$model->status],
        ];
    }

    public function filterByCategory(int $id)
    {
        $model = $this->model->where("category_id", $id);

        return $model;
    }

    public function getprice(int $id)
    {
        $model = $this->findById($id);
        $item_price = ItemService::getInstance()->getprice($model->item_id);
        $price = $item_price*$model->qty;
        return $price;
    }

    public function block(int $id)
    {
        $model = $this->findById($id);
        $model->status = 2;
        $model->save();
        return __("message.content_block");
    }

    public function unblock(int $id)
    {
        $model = $this->findById($id);
        $model->status = 1;
        $model->save();
        return __("message.content_unblock");
    }

    public function getReturnedValue ($model)
    {
        $price = "Free";
            $item = ItemService::getInstance()->getActiveItems($model->user_id)[0];
            
            if ($model->qty == 0 || $model->qty == null) {
                $price = "Free";
            } else {
                $price = $model->qty . ' x ' . $item['name'];
            }
        return [
            "id" => $model->id,
            "creator" => $model->user->name,
            "title" => $model->title,
            "content" => $model->content,
            "category_id" => $model->category_id,
            "category" => $model->category,
            "thumbnail" => $model->thumbnail_path, //route("api.contentthumbnail.preview", ["file_name" => $model->thumbnail ?: Constant::UNKNOWN_STATUS]),
            // "cover_image" => route("api.contentcover.preview", ["file_name" => $model->cover_image ?: Constant::UNKNOWN_STATUS]),
            "file" => URL('/') .'/'. Constant::CONTENT_FILE_PATH .'/'. $model->file,
            "item" => $item['name'],
            "item_id" => $model->item_id,
            "item_icon" => $item['icon'],
            "qty" => $model->qty,
            "price" => $price,
            "external_link" => $model->external_link,
            "sensitive_content" => (bool) $model->sensitive_content,
            "status" => Constant::POST_STATUS[$model->status],
            "slug" => $model->slug,     // Str::slug($model->title, '-').'-'.$model->id,
            "created_at" => $model->created_at->diffForHumans(),
            "likes_count" => $model->likes->count(),
            "comments_count" => $model->comments->count()
        ];
    }
    
    public function previewThumbnail($filename, UploadService $uploadService)
    {
        return $uploadService->preview(Constant::CONTENT_THUMBNAIL_PATH ."/$filename");
    }
    
    public function previewCover($filename, UploadService $uploadService)
    {
        return $uploadService->preview(Constant::CONTENT_COVER_IMAGE_PATH ."/$filename");
    }
}
