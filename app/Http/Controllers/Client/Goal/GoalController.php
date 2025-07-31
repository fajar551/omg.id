<?php

namespace App\Http\Controllers\Client\Goal;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\Utils;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\GoalService;
use Illuminate\Http\Request;

class GoalController extends Controller {
    
    protected $services; 

    public function __construct(GoalService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {
            $userid = $request->user()->id;

            $data = [
                'goal' => $goal = $this->services->getActiveGoals($userid),
                'goalProgress' => $goal ? $this->services->getGoalProgress($goal["id"]) : null,
            ];

            return view('client.goal.mygoal.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function create(Request $request) {
        try {
            $data = [
                'jsDateFormat' => Utils::defaultDateFormat(true),
            ];

            return view('client.goal.mygoal.create', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'goal.mygoal.index');
        }
    }

    public function edit(Request $request) {
        try {
            $userid = $request->user()->id;
            $goalid = $request->id;
            
            $data = [
                'goal' => $this->services->getCreatorGoal($goalid, $userid, true),
                'dateFormat' => Utils::defaultDateFormat(),
                'jsDateFormat' => Utils::defaultDateFormat(true),
            ];
            // dd($data);
            return view('client.goal.mygoal.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'goal.mygoal.index');
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->input();
            $data["user_id"] = $request->user()->id;

            $this->services->store($data);
            
            return WebResponse::success(__("message.save_success"), 'goal.mygoal.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'goal.mygoal.create');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->input();
            $data["user_id"] = $request->user()->id;

            $this->services->editById($request->id, $data);
            
            return WebResponse::success(__("message.update_success"), 'goal.mygoal.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'goal.mygoal.edit', ['id' => $request->id]);
        }
    }

    public function setReached(Request $request) {
        try {
            // TODO: set reached if progress more than 100%
            $this->services->setReached($request->id);
            
            return WebResponse::success(__("message.goal_reached"), 'goal.mygoal.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

}
