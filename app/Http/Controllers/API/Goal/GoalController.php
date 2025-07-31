<?php

namespace App\Http\Controllers\API\Goal;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\GoalService;
use App\Src\Services\Eloquent\PageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class GoalController extends Controller {
    
    protected $services; 

    public function __construct(GoalService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {
            $userid = $request->user()->id;
            $goalid = $request->id;

            $result = [
                'goal' => $goal = $this->services->getCreatorGoal($goalid, $userid),
                'goalProgress' => $goal ? $this->services->getGoalProgress($goal["id"]) : null,
            ];

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function store(Request $request) {
        try {
            $data = $request->input();
            $data["user_id"] = $request->user()->id;

            $result = $this->services->store($data);

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->input();
            $data["user_id"] = $request->user()->id;
            
            $result = $this->services->editById($request->id, $data);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function delete(Request $request) {
        try {
            $this->services->deleteById($request->id);

            return ApiResponse::success([
                "message" => __("message.delete_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getGoals(Request $request)
    {
        try {
            $userid = $request->user()->id;
            
            return $this->services->getDataTableGoals($userid);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getDetail(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $goalid = $request->id;

            $result = [
                'goal' => $goal = $this->services->getCreatorGoal($goalid, $userid),
                'goalProgress' => $goal ? $this->services->getGoalProgress($goal["id"]) : null,
                'isPreview' => true,
            ];

            $result['goal_template'] = View::make('components.goal-card', $result)->render();

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setAcive(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->setactive($request->input('id'), $user_id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setReached(Request $request)
    {
        try {
            $this->services->setReached($request->input('id'));

            return ApiResponse::success([
                "message" => __("message.goal_reached"),
                "data" => [],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }
    
    public function getAcive($page_url)
    {
        try {
            $pages = PageService::getInstance()->getPage($page_url);
            $userid = $pages['user_id'];

            /* Get Creator Goal */
            $creatorGoal = GoalService::getInstance()->getActiveGoals($userid);
            $creatorGoal = $creatorGoal ? [
                'goal' => $creatorGoal,
                'goalProgress' => GoalService::getInstance()->getGoalProgress($creatorGoal["id"]),
            ] : [];

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $creatorGoal,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}
