<?php

namespace App\Src\Services\Eloquent;

use App\Models\User;
use App\Src\Base\IBaseService;
use App\Src\Exceptions\NotFoundException;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use App\Src\Services\Spatie\PermissionService;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\UserValidator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Str;

class UserService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(User $model, UserValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new User(), new UserValidator());
    }

    public function getProfile($userid)
    {
        $model = $this->findById($userid);
        if ($model->status == 0) {
            throw new NotFoundException(__('message.user_deactivated'), []);
        }

        if ($model->status == 2) {
            throw new NotFoundException(__('message.user_suspended'), []);
        }

        return $this->formatResult($model);
    }

    public function show($userid)
    {
        $model = $this->findById($userid);
        
        return $this->formatResult($model);
    }

    public function updateProfile(int $id, array $data, $uploadService)
    {
        $this->validator->validateProfile(array_merge(["id" => $id], $data));

        $model = $this->findById($id);

        $model->name= $data["name"];
        $model->username = $data["username"];
        $model->gender = $data["gender"];
        $model->phone_number = preg_replace('/\s+/', '-', $data["phone_number"]);
        $model->address = $data["address"];

        if (isset($data["profile_picture"])) {
            $uploadData = [
                "prefix" => "pp",
                "path" => Constant::PROFILE_UPLOAD_PATH,
                "file" => @$data["profile_picture"],
            ];

            if ($model->profile_picture) {
                $uploadData["old_file"] = Constant::PROFILE_UPLOAD_PATH ."/{$model->profile_picture}";
            }

            $model->profile_picture = $uploadService->upload($uploadData);
        }

        $model->save();
        
        return $this->formatResult($model);
    }

    public function updateProfilePicture(int $id, array $data, $uploadService)
    {
        $this->validator->validateProfilePicture(array_merge(["id" => $id], $data));

        $model = $this->findById($id);

        if (isset($data["profile_picture"])) {
            $file = $uploadService->handleBase64File($data["profile_picture"]);
            $uploadData = [
                "prefix" => "pp",
                "path" => Constant::PROFILE_UPLOAD_PATH,
                "file" => $file['file'],
                "ext" => $file['type'],
            ];

            if ($model->profile_picture) {
                $uploadData["old_file"] = Constant::PROFILE_UPLOAD_PATH ."/{$model->profile_picture}";
            }

            $model->profile_picture = $uploadService->upload($uploadData, 'base64');
        }

        $model->save();
        return $model->profile_picture;
    }
    
    public function storeAdmin(array $data)
    {
        $this->validator->validateStoreAdmin($data);

        $model = $this->model;
        $model->name = $data["name"];
        $model->username = $data["username"];
        $model->email = $data["email"];
        $model->gender = $data["gender"];
        $model->status = $data["status"];
        $model->address = $data["address"];
        $model->password = bcrypt($data['password']);

        if (isset($data["profile_picture"])) {
            $uploadData = [
                "prefix" => "pp",
                "path" => Constant::PROFILE_UPLOAD_PATH,
                "file" => @$data["profile_picture"],
            ];

            $model->profile_picture = UploadService::getInstance()->upload($uploadData);
        }

        if (isset($data["roles"])) {
            $model->syncRoles($data["roles"]);
        }

        if (isset($data["permissions"])) {
            $model->syncPermissions($data["permissions"]);
        }

        $model->save();
        
        return $this->formatResult($model);
    }

    public function updateAdmin(array $data)
    {
        $this->validator->validateUpdateAdmin($data);

        $model = $this->findById($data["id"]);
        $model->name = $data["name"];
        $model->username = $data["username"];
        $model->email = $data["email"];
        $model->gender = $data["gender"];
        $model->status = $data["status"];
        $model->address = $data["address"];
        if (isset($data['password'])) {
            $model->password = bcrypt($data['password']);
        }

        if (isset($data["profile_picture"])) {
            $uploadData = [
                "prefix" => "pp",
                "path" => Constant::PROFILE_UPLOAD_PATH,
                "file" => @$data["profile_picture"],
            ];

            if ($model->profile_picture) {
                $uploadData["old_file"] = Constant::PROFILE_UPLOAD_PATH ."/{$model->profile_picture}";
            }

            $model->profile_picture = UploadService::getInstance()->upload($uploadData);
        }

        $model->save();

        if (isset($data["roles"])) {
            $model->syncRoles($data["roles"]);
        }

        if (isset($data["permissions"])) {
            $model->syncPermissions($data["permissions"]);
        }
        
        return $this->formatResult($model);
    }

    public function changePassword(array $data)
    {
        $this->validator->validateChangePassword($data);

        $model = $this->findById($data["userid"]);
        $model->password = bcrypt($data["password"]);
        $model->save();
    }

    public function getSupportPage($userid)
    {
        $model = $this->findById($userid);
        $page = $model->page;
        $result = [
            "id" => null,
            "page_url" => $model->username,
            "page_message" => __("message.support_page_message"),
        ];

        if (!$page) {
            $page = $model->page()->create([
                'name' => $model->name,
                'page_url' => Str::slug($model->username, "-"),
                'status' => 1,
                'page_message' => __("message.default_page_message"),
            ]);
        }
        
        if ($page) {
            $page = PageService::getInstance()->formatResult($page);
            $result = [
                "id" => $page["id"],
                "page_url" => $page["page_url"],
                "page_message" => $page["page_message"],
            ];
        }

        return [
            "support_page" => $result
        ];
    }

    public function updateSupportPage($userid, array $data)
    {
        $this->validator->validateUpdateSupportPage($data);

        $model = $this->findById($userid);

        $model->page()->updateOrCreate(
            ['user_id' => $data["userid"]],
            [
                "page_url" => Str::slug($data["page_url"], "-"),
                "page_message" => $data["page_message"],
            ]
        );

        $page = $model->page;
        $page = PageService::getInstance()->formatResult($page);
        $result = [
            "page_url" => $page["page_url"],
            "page_message" => $page["page_message"],
        ];

        return [
            "support_page" => $result
        ];
    }

    public function checkusername(string $username)
    {
        return $this->validator->validateUsername($username);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function suspend(int $id)
    {
        $model = $this->findById($id);
        $model->status = 2;
        $model->save();
        return __("message.suspended");
    }

    public function unsuspend(int $id)
    {
        $model = $this->findById($id);
        $model->status = 1;
        $model->save();
        return __("message.unsuspended");
    }

    public function delete($userid)
    {
        $model = $this->findById($userid);

        return $model->delete();
    }

    public function preview($filename, $uploadService)
    {
        return $uploadService->preview(Constant::PROFILE_UPLOAD_PATH ."/$filename", public_path("template/images/user/user.png"));
    }

    public function dtListCreator(array $params)
    {
        $criteria = $params["customSearch"];

        $query = $this->model->query();
        $this->buildCustomSearch($query, $criteria)->role('creator');

        return datatables()->of($query)
                            ->addIndexColumn()
                            ->addColumn('creator_card', function($row) {
                                $row['page_id'] = $row->page->id;
                                $row['editor_pick'] = $row->page->editor_pick;
                                $row['featured'] = $row->page->featured;
                                return View::make('components.creator-card1', $row);
                            })
                            ->addColumn('summary', function($row) {
                                $id = $row->id;
                                $route = route('support.index', ['page_name' => $row->page->page_url]);
                                $summaries = [
                                    __("form.lbl_address") => $row->address,
                                    __("form.lbl_status") => Utils::getLabelForStatus(Constant::getUserStatus($row->status)),
                                    __("form.lbl_registered_at") => Utils::formatDate($row->created_at) .", <i>" .$row->created_at->diffForhumans() ."</i>",
                                    __("form.lbl_modified_at") => Utils::formatDate($row->updated_at) .", <i>" .$row->updated_at->diffForhumans() ."</i>",
                                    __("Page Name") => $row->page->name,
                                    __("Support Page") => '<a href="'. $route .'" target="__blank">' .$route .'</a>' ,
                                    // TODO: Add more summaries
                                ];
                                
                                return View::make('components.creator-summary', compact('summaries', 'id'));
                            })
                            // ->addColumn('actions', function($row) {
                            //     $id = $row->id;
                            //     $actions = Utils::getActionFor("view", null, 'onclick="detail(this)"', ["id" => $id]);
                            //     $actions .= Utils::getActionFor("edit");
                            //     $actions .= Utils::getActionFor("delete");
            
                            //     return $actions;
                            // })
                            ->orderColumn('creator_card', function($query, $order) {
                                $query->orderBy('name', $order);
                            })
                            // ->filter(function ($query) {
                            //     $columns = request()->input("columns");
                            //     $search = request()->input("search");
                            //     $customSearch = request()->input("customSearch");

                            //     $model = $query->getModel();
                            //     $tableName = $model->getTable();
                            //     $searchVal = $search["value"];

                            //     foreach ($columns as $item) {
                            //         $searchable = $item["searchable"];
                            //         if ($searchable == 'true') {
                            //             $columnName = $item["name"];
                            //             if ($searchVal && Schema::hasColumn($tableName, $columnName)) {
                            //                 $query->orWhereEncrypted($columnName, 'like', "%$searchVal%");
                            //             }
                            //         }
                            //     }
                            // }, true)
                            ->rawColumns(['actions', 'creator_card', 'summary'])
                            ->toJson();
    }

    public function dtListAdmin(array $params)
    {
        // $query = $this->model->role('admin');
        $query = $this->model->whereHas('roles', function($q) {
            return $q->whereIn('name', ['admin', 'developer']);
        });

        return datatables()->of($query)
                            ->addIndexColumn()
                            ->addColumn('summary', function($row) {
                                $id = $row->id;
                                $summaries = [
                                    __("form.lbl_status") => Utils::getLabelForStatus(Constant::getUserStatus($row->status)),
                                    __("form.lbl_roles") => implode(", ", $row->roles->pluck("name")->toArray()),
                                    __("form.lbl_permissions") => __('form.lbl_selected_permissions', ["selected" => $row->permissions->count(), "total" => PermissionService::getInstance()->getAll()->count()]),
                                    __("form.lbl_registered_at") => Utils::formatDate($row->created_at) .", <i>" .$row->created_at->diffForhumans() ."</i>",
                                    __("form.lbl_modified_at") => Utils::formatDate($row->updated_at) .", <i>" .$row->updated_at->diffForhumans() ."</i>",
                                ];
                                
                                return View::make('components.creator-summary', compact('summaries', 'id'));
                            })
                            ->addColumn('username_email', function($row) {
                                return "$row->username / $row->email";
                            })
                            ->addColumn('actions', function($row) use($params) {
                                $id = $row->id;
                                $actions = "";

                                $actions .= Utils::getActionFor("edit", route('admin.administrator.list.edit', ["id" => $id]));
                                if ($params["adminid"] != $id) {
                                    $actions .= Utils::getActionFor("delete", null, 'onclick="deleteConfirm(this)"', ["id" => $id]);
                                }
            
                                return $actions;
                            })
                            ->orderColumn('creator_card', function($query, $order) {
                                $query->orderBy('name', $order);
                            })
                            ->rawColumns(['actions', 'summary'])
                            ->toJson();
    }

    public function buildCustomSearch($query, $criteria)
    {
        if (isset($criteria["name"]) && $criteria["name"]) {
            $query->orWhereEncrypted("name", 'like', "%{$criteria["name"]}%");
        }

        if (isset($criteria["username"]) && $criteria["username"]) {
            $query->orWhere("username", 'like', "%{$criteria["username"]}%");
        }

        if (isset($criteria["email"]) && $criteria["email"]) {
            $query->orWhere("email", 'like', "%{$criteria["email"]}%");
        }

        if (isset($criteria["status"])) {
            $query->orWhere("status", $criteria["status"]);
        }

        if (isset($criteria["address"]) && $criteria["address"]) {
            $query->orWhereEncrypted("address", 'like', "%{$criteria["address"]}%");
        }

        // TODO: Add and check query custom search for page_url , sensitive_content
        if (isset($criteria["page_name"]) || isset($criteria["page_url"]) || isset($criteria["sensitive_content"])) {
            $query->whereHas('page', function($q) use($criteria) {
                if (isset($criteria["page_name"]) && $criteria["page_name"]) {
                    $q->whereEncrypted("name", 'like', "%{$criteria["page_name"]}%");
                }

                if (isset($criteria["page_url"]) && $criteria["page_url"]) {
                    $q->where("page_url", 'like', "%{$criteria["page_url"]}%");
                }

                if (isset($criteria["sensitive_content"]) && $criteria["sensitive_content"]) {
                    $q->where("sensitive_content", $criteria["sensitive_content"]);
                }
            }); 
        }

        return $query;
    }

    public function selectSearch($search)
    {
    	$data = [];
        if(isset($search)){
            $data =$this->model->whereEncrypted('name', 'LIKE', "%$search%")->get();
        }
        return response()->json($data);
    }

    public function total_creator(array $params = null)
    {
        $model = $this->model;
        if (isset($params['today'])) {
            $model = $model->whereDate('created_at', $params['today']);
        }
        
        return $model->count();
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "username" => $model->username,
            "email" => $model->email,
            "gender" => $model->gender,
            "profile_picture" => route("api.profile.preview", ["file_name" => $model->profile_picture ?: Constant::UNKNOWN_STATUS]), 
            "status" => Constant::getUserStatus($model->status),
            "phone_number" => $model->phone_number,
            "address" => $model->address,
            "created_at" => $model->created_at->format("d-m-Y H:i"),
            "updated_at" => $model->updated_at->format("d-m-Y H:i"),
        ];
    }
}