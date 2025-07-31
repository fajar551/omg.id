<?php

namespace App\Http\Controllers\Client\Creator;

use App\Http\Controllers\Controller;
use App\Src\Exceptions\NotFoundException;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\ContentCategoryService;
use App\Src\Services\Eloquent\ContentService;
use App\Src\Services\Eloquent\PageService;
use Illuminate\Http\Request;
use App\Src\Services\Eloquent\SupportService;
use App\Models\Product;
use App\Models\PaymentMethod;

class CreatorController extends Controller
{

    protected $services;
    protected $contentService;
    protected $contentCategoryServices;
    protected $filterRoute = [
        "client",
        "clients",
        "admin",
        "admins",
        "home",
        "dashboard",
        "term-of-service",
        "term-of-police",
        "report",
        "login",
        "register",
        "logout",
    ];

    public function __construct(SupportService $services, ContentService $contentService, ContentCategoryService $contentCategoryServices)
    {
        $this->services = $services;
        $this->contentService = $contentService;
        $this->contentCategoryServices = $contentCategoryServices;
    }

    public function index(Request $request)
    {
        !in_array($request->page_name, $this->filterRoute) ?: abort(404);

        try {
            $data = $this->services->getPageData([
                "page_name" => $request->page_name,
                "supporter_id" => auth()->check() ? $request->user()->id : null
            ]);
            $supporter_id = auth()->check() ? $request->user()->id : null;
            $data['support_history'] = $this->services->historypage($data['page']['user_id']);
            $data['content'] = ContentService::getInstance()->getPublished($data['page']['user_id'], null, 3, $supporter_id, null, 1);
            // Tambahkan query produk milik creator
            $type = request('type');
            $productsQuery = Product::where('user_id', $data['page']['user_id']);
            if ($type) {
                $productsQuery->where('type', $type);
            }
            $data['products'] = $productsQuery->get();

            // Tambahkan payment methods untuk modal
            $data['paymentMethods'] = PaymentMethod::where('disabled', null)->orderBy('order', 'ASC')->get();

            // if (auth()->check()) {
            //     $data['supporter'] = [
            //         "email" => $request->user()->email
            //     ];
            // }

            // dd($data);

            session(['url.intended' => url()->current()]);

            return view('client.creator.index', $data);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage());
            }

            return abort(500, $ex->getMessage());
        }
    }

    public function content(Request $request)
    {
        !in_array($request->page_name, $this->filterRoute) ?: abort(404);

        try {
            $data = $this->services->getPageData([
                "page_name" => $request->page_name,
                "supporter_id" => auth()->check() ? $request->user()->id : null
            ]);
            $supporter_id = auth()->check() ? $request->user()->id : null;
            $order = $request->order;
            $slug = explode('-', $request->slug);
            $slug = array_pop($slug);
            $category = $request->category;
            $data['order'] = $order;
            $data['category'] = $category;
            $data['content'] = ContentService::getInstance()->getPublished($data['page']['user_id'], $category, 6, $supporter_id, $order, null, $slug);
            $data['content_category'] = ContentCategoryService::getInstance()->getCategory($data['page']['user_id']);
            // dd($data);

            session(['url.intended' => url()->current()]);

            return view('client.creator.content', $data);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage());
            }

            return abort(500, $ex->getMessage());
        }
    }

    public function savedContent(Request $request)
    {
        !in_array($request->page_name, $this->filterRoute) ?: abort(404);

        try {
            $data = $this->services->getPageData([
                "page_name" => $request->page_name,
                "supporter_id" => auth()->check() ? $request->user()->id : null
            ]);
            $supporter_id = auth()->check() ? $request->user()->id : null;
            $order = $request->order;
            $data['order'] = $order;
            $data['content'] = ContentService::getInstance()->getSubscribed($data['page']['user_id'], null, 6, $supporter_id, $order);
            // dd($data['content']);

            session(['url.intended' => url()->current()]);

            return view('client.creator.saved-content', $data);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage());
            }

            return abort(500, $ex->getMessage());
        }
    }

    public function contentDetail(Request $request)
    {
        try {
            // TODO: Validasi creator_page dengan content
            // TODO: Get data page detail 
            $slug = explode('-', $request->slug);
            $content_id = (int) end($slug);

            $user_id = auth()->check() ? $request->user()->id : null;
            $request->merge(['content_id' => $content_id, 'supporter_id' => $user_id]);
            $result = $this->contentService->detail($request->all());
            $relatedContent = $this->contentService->relatedContent($request->all());
            // $pageDetail = PageService::getInstance()->getPage($request->page_name, $user_id);
            $data = $this->services->getPageData([
                "page_name" => $request->page_name,
                "supporter_id" => $user_id
            ]);

            $socialShare = null;
            if (@$result['access']) {
                $socialShare = \Share::currentPage('Baca "' . $result['content']->title . '" di ' . env('APP_NAME'))
                    ->facebook()
                    ->twitter()
                    ->telegram()
                    ->whatsapp();
            }

            session(['url.intended' => url()->current()]);

            return view('client.creator.detail', array_merge([
                'access' => @$result['access'],
                'message' => @$result['message'],
                'content' => $result['content'],
                'socialShare' => $socialShare,
                'pageDetail' => $data['page'],
                'relatedContent' => $relatedContent,
            ], $data));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    public function productDetail(Request $request)
    {
        !in_array($request->page_name, $this->filterRoute) ?: abort(404);

        try {
            // Get page data
            $data = $this->services->getPageData([
                "page_name" => $request->page_name,
                "supporter_id" => auth()->check() ? $request->user()->id : null
            ]);

            // Get product detail
            $product = Product::where('id', $request->product_id)
                ->where('user_id', $data['page']['user_id'])
                ->first();

            if (!$product) {
                abort(404, 'Produk tidak ditemukan');
            }

            // Get payment methods for modal
            $paymentMethods = PaymentMethod::where('disabled', null)
                ->orderBy('order', 'ASC')
                ->get();

            session(['url.intended' => url()->current()]);

            return view('products.product-detail-public', [
                'product' => $product,
                'pageName' => $request->page_name,
                'paymentMethods' => $paymentMethods,
                'page' => $data['page'],
                'user' => $data['user'] ?? null
            ]);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage());
            }

            return abort(500, $ex->getMessage());
        }
    }
}
