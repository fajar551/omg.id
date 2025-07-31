<?php

namespace App\Http\Controllers\Client\Page;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\GoalService;
use App\Src\Services\Eloquent\PageCategoryService;
use App\Src\Services\Eloquent\PageService;
use App\Src\Services\Eloquent\SocialLinkService;
use Illuminate\Http\Request;
use App\Src\Services\Upload\UploadService;
use App\Src\Services\Eloquent\ContentService;

class PageController extends Controller
{

    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index(Request $request)
    {
        try {
            $creatorGoal = GoalService::getInstance()->getActiveGoals($request->user()->id);
            if ($creatorGoal) {
                if ($creatorGoal['visibility'] != 2) {      // != Private
                    $creatorGoal = [
                        'goal' => $creatorGoal,
                        'goalProgress' => GoalService::getInstance()->getGoalProgress($creatorGoal["id"]),
                    ];
                } else {
                    $creatorGoal = [];
                }
            }
            $data = [
                'data' => PageService::getInstance()->getDetail($request->user()->page->id),
                'social_link' => SocialLinkService::getInstance()->getSocialLink($request->user()->id),
                'creatorGoal' => $creatorGoal,
                'category' => PageCategoryService::getInstance()->getAll()
            ];
            $data['content'] = ContentService::getInstance()->getPublished($request->user()->id, null, 2, null);
            // Tambahkan pengambilan produk
            $data['products'] = \App\Models\Product::where('user_id', $request->user()->id)->get();
            $a = PageService::getInstance()->getDetail($request->user()->page->id);
            // dd($data);
            return view('client.page.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'page.index');
        }
    }

    public function editcover(Request $request)
    {
        try {
            PageService::getInstance()->setCover($request->all(), $this->uploadService);
            return WebResponse::success(__("message.update_success"), 'page.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'page.index');
        }
    }

    public function setProfile(Request $request)
    {
        try {
            // dd($request->avatar);
            PageService::getInstance()->setProfile($request->id, $request->all(), $this->uploadService);
            return WebResponse::success(__("message.update_success"), 'page.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'page.index');
        }
    }

    public function setSummary(Request $request)
    {
        try {
            // dd($request->avatar);
            PageService::getInstance()->setSummary($request->id, $request->summary);
            return WebResponse::success(__("message.update_success"), 'page.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'page.index');
        }
    }

    public function setvideo(Request $request)
    {
        try {
            // dd($request->avatar);
            PageService::getInstance()->setVideo($request->id, $request->video);
            return WebResponse::success(__("message.update_success"), 'page.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'page.index');
        }
    }

    public function products()
    {
        $products = [
            'data' => \App\Models\Product::where('user_id', auth()->id())->get()->toArray()
        ];
        return view('client.page.products', compact('products'));
    }
}
