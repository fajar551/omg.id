<?php

namespace App\Http\Controllers\Client\Explore;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\ExploreService;
use Illuminate\Http\Request;

class ExploreController extends Controller {
    
    protected $services;

    public function __construct(ExploreService $services) {
        $this->services = $services;
    }
    
    public function index(Request $request) {
        try {
            return view('client.explore.index', []);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

}
