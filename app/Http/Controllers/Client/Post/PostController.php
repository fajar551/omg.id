<?php

namespace App\Http\Controllers\Client\Post;
use App\Http\Controllers\Controller;
use App\Src\Services\Eloquent\PageService;
use App\Src\Services\Eloquent\PostService;
use Illuminate\Http\Request;

class PostController extends Controller {
    
    protected $services;

    public function __construct(
        PostService $services
    ) {
        $this->services = $services;
    }

    public function index(Request $request)
    {
        try {
            $page = PageService::getInstance()->getPage($request->page_name);
            // dd($page);
            $result = $this->services->getPublishedPosts($page['user_id']);
            $data = [
                "data" => $result,
            ];

            return view('client.post.index', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }

    public function show(Request $request)
    {
        try {
            $slug = explode('-', $request->slug);
            $post_id = end($slug);
            $result = $this->services->getDetail($post_id);
            $data = [
                "data" => $result,
            ];

            return view('client.content.detail', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }
}
