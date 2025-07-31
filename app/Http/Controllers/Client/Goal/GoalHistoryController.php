<?php

namespace App\Http\Controllers\Client\Goal;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\GoalService;
use Illuminate\Http\Request;

class GoalHistoryController extends Controller {
    
    protected $services; 

    public function __construct(GoalService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {
            $data = [];

            return view('client.goal.history.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function create(Request $request) {
        try {
            $data = [];

            return view('client.goal.history.create', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'goal.history.index');
        }
    }

    public function delete(Request $request) {
        try {
            $userid = $request->user()->id;
            $goalid = $request->id;

            $this->services->deleteCreatorGoal($goalid, $userid);

            return WebResponse::success(__("message.delete_success"), 'goal.history.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'goal.history.index');
        }
    }

    public function dtGoalHistory(Request $request)
    {
        $userid = $request->user()->id;

        return $this->services->getDataTableGoals($userid);
    }
    
}
