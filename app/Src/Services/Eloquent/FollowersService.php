<?php

namespace App\Src\Services\Eloquent;

use App\Models\Follower;
use App\Models\User;
use App\Src\Base\IBaseService;
use App\Src\Validators\UserValidator;
use App\Src\Helpers\Constant;

class FollowersService implements IBaseService {

    protected $model;
    protected $modelUser;
    protected $userValidator;
    
    public function __construct(Follower $model, User $modelUser, UserValidator $userValidator){
        $this->model = $model;
        $this->modelUser = $modelUser;
        $this->userValidator = $userValidator;
    }

    public static function getInstance()
    {
        return new static(new Follower(), new User(), new UserValidator());
    }

    public function findById($id)
    {

        return $this->model->find($id);
    }

    public function findUserById($id)
    {
        $this->userValidator->validateId($id);

        return $this->modelUser->find($id);
    }

    public function follow (int $user_id, int $followers_id)
    {
        $model = $this->model->where(array('user_id' => $user_id, 'followers_id' => $followers_id))->first();
        $user = $this->modelUser->find($user_id);
        $pagename = $user->page ? $user->page->name : $user->username;
        
        if ($model) {
            $model = $this->findById($model->id);
            $model->delete();

            
            return [
                'follow' => false,
                'message' => __('message.unfollow'),
                'info' => __("message.unfollow_info", ['creator_page' => $pagename]),
            ];
        }else {
            $this->model->user_id = $user_id;
            $this->model->followers_id = $followers_id;
            $this->model->save();
            
            return [
                'follow' => true,
                'message' => __('message.following'),
                'info' => __("message.follow_info", ['creator_page' => $pagename]),
            ];
        }
    }

    public function gettotalfollowers(int $user_id)
    {
        $result = $this->model->where(array('user_id' => $user_id))->get()->count();
        return $result;
    }

    public function getFollowInfo($userid, $count_only = false, $followers_id = null)
    {
        if ($count_only) {
            return [
                "followers_count" => $this->followersCount($userid),
                "followings_count" => $this->followingsCount($userid),
                "isFollowing" => $this->isFollowing($userid, $followers_id),
            ];
        }

        return [
            "followers_count" => $this->followersCount($userid),
            "followings_count" => $this->followingsCount($userid),
            "followers" => $this->getFollowers($userid),
            "followings" => $this->getFollowings($userid),
            "isFollowing" => $this->isFollowing($userid, $followers_id),
        ];
    }

    public function followersCount($userid)
    {
        $user = $this->findUserById($userid);

        return $user->followers->count();
    }

    public function followingsCount($userid)
    {
        $user = $this->findUserById($userid);

        return $user->followings->count();
    }

    public function getFollowers($userid)
    {
        $user = $this->findUserById($userid);

        return $user->followers->map(function($model){
            return $this->formatResult($model);
        });
    }

    public function getFollowings($userid)
    {
        $user = $this->findUserById($userid);

        return $user->followings->map(function($model){
            return $this->formatResult($model);
        });
    }

    public function getFollowingsPage($userid)
    {
        $user = $this->modelUser->find($userid);
        $followings = $user->followings();

        $data = $followings->paginate(12);
        $meta_data = [
            "current_page" => $data->currentPage(),
            "last_page" =>  $data->lastPage(),
            "per_page" => $data->perPage(),
            "total_page" => $data->total(),
            "next_page_url" => $data->nextPageUrl(),
            "links" => (string) $data->links(),
        ];
        $result = $followings->get()->map(function($model, $userid){
            return $this->formatResultPage($model, $userid);
        });
        
        return ['data' => $result, 'pagging' => $meta_data];
    }

    public function isFollowing($creator_id, $followers_id)
    {
        if (!$followers_id) return false;

        $user = $this->findUserById($creator_id);

        return $user->followers()->where('followers_id', $followers_id)->count() > 0;
    }

    public function formatResult($model) {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "page_url" => $model->page->page_url,
        ];
    }

    public function formatResultPage($model, $followers_id) {
        $page_category = $model->page->category_id != null ? PageCategoryService::getInstance()->getById($model->page->category_id) : [];
        return [
            "id" => $model->id,
            "user_id" => $model->page->user_id,
            "name" => $model->page->name,
            "page_url" => $model->page->page_url,
            "page_category" => $page_category['title'] ?? '-',
            'avatar' => route("api.profile.preview", ["file_name" => $model->profile_picture ?: Constant::UNKNOWN_STATUS]),
            'cover_image' => route("api.pagecover.preview", ["file_name" => $model->page->cover_image ?: Constant::UNKNOWN_STATUS]),
            "page_message" => $model->page->page_message,
            "follow_info" => $this->getFollowInfo($model->page->user_id, false, $followers_id)
        ];
    }
}
