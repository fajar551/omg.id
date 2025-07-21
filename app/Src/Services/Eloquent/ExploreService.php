<?php

namespace App\Src\Services\Eloquent;

use App\Models\Page;
use App\Models\PageCategory;
use App\Src\Helpers\Constant;
use App\Src\Validators\ExploreValidator;

class ExploreService {

    protected $modelCategory;
    protected $modelPage;
    protected $validator;

    public function __construct(PageCategory $modelCategory, Page $modelPage, ExploreValidator $validator){
        $this->modelCategory = $modelCategory;
        $this->modelPage = $modelPage;
        $this->validator = $validator;
    }

    /**
     * Explore the creator
     * 
     * @param array $data
     * @return array
     */
    public function explore(array $data)
    {
        $this->validator->validateParam($data);

        $category_id = $data['category_id'];
        $keywords = @$data['keywords'];
        $sortBy = @$data['sortBy'];
        $user_id = @$data['user_id'];

        $data = $this->modelPage
                ->select('id', 'user_id', 'name', 'page_url', 'avatar', 'category_id', 'cover_image', 'bio', 'featured', 'editor_pick', 'page_message')
                ->when($keywords, function ($q) use ($keywords, $category_id) {                        
                    $q->when($category_id > 0, function($q) use($category_id) {
                            $q->where('category_id', $category_id);
                        })
                        ->where('name', 'LIKE', "%{$keywords}%")
                        ->orWhere('page_url', 'LIKE', "%{$keywords}%");
                })
                ->when($category_id > 0, function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                })
                ->when($sortBy, function ($q) use ($sortBy) {
                    if ($sortBy == 'featured') $q->where('featured', 1);
                    if ($sortBy == 'editorpick') $q->where('editor_pick', 1);
                })
                ->whereHas('user', function($q) {
                    return $q->where('status', 1);
                })
                ->withCount(['content'])
                ->orderBy('content_count', 'DESC')
                ->paginate(12);

        $meta_data = [
            "current_page" => $data->currentPage(),
            "last_page" =>  $data->lastPage(),
            "per_page" => $data->perPage(),
            "total_page" => $data->total(),
            "next_page_url" => $data->nextPageUrl(),
            "links" => (string) $data->links(),
        ];

        // TODO: Improve this
        $data = $data->map(function ($modelPage) use($user_id) {
            return $this->formatedvalue($modelPage, ['followers_id' => $user_id]);
        });
        
        $result = [
            "id"=> 0,
            "title" => 'All',
            "pages" => $data
        ];

        if ($category_id > 0) {
            $category = PageCategoryService::getInstance()->getById($category_id);
            $result = [
                "id"=> $category['id'],
                "title" => $category['title'],
                "pages" => $data
            ];
        }

        return [
            "data" => $result,
            "pagging" => $meta_data
        ];
    }

    public function formatedvalue($model, $params = [])
    {
        $page_category = $model->category_id != null ? PageCategoryService::getInstance()->getById($model->category_id) : [];

        return [
            "user_id" => $model->user_id,
            "name" => $model->name,
            "page_url" => $model->page_url,
            "page_category" => $page_category['title'] ?? '-',
            'avatar' => route("api.profile.preview", ["file_name" => $model->user->profile_picture ?: Constant::UNKNOWN_STATUS]),
            'cover_image' => route("api.pagecover.preview", ["file_name" => $model->cover_image ?: Constant::UNKNOWN_STATUS]),
            "bio" => $model->bio,
            "page_message" => $model->page_message,
            "content_count" => $model->content_count,
            "follow_info" => FollowersService::getInstance()->getFollowInfo($model->user_id, true, @$params['followers_id']),
        ];
    }

}
