<?php

namespace App\Src\Services\Eloquent;

use App\Models\Goal;
use App\Models\Page;
use App\Src\Exceptions\NotFoundException;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use App\Src\Validators\GoalValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class GoalService {

    protected $model;
    protected $validator;
    protected $modelPage;

    public function __construct(Goal $model, GoalValidator $validator, Page $modelPage) {
        $this->model = $model;
        $this->validator = $validator;
        $this->modelPage = $modelPage;
    }

    public static function getInstance()
    {
        return new static(new Goal(), new GoalValidator(), new Page());
    }

    public function store(array $data)
    {
        $data['target'] = preg_replace('/[^0-9]+/', '', $data['target']);
        $this->validator->validateStore($data);
        
        $model = $this->model;
        $model->user_id= $data["user_id"];
        $model->title = ucwords($data["title"]);
        $model->description = @$data["description"];
        $model->target = $data["target"];
        $model->visibility = $data["visibility"];
        $model->target_visibility = $data["target_visibility"];
        // $model->status = $data["status"];
        $model->enable_milestone = $data["enable_milestone"] ?? 0;
        if (@$data['enable_milestone']) {
            $model->start_at = Carbon::parse($data["start_at"])->format(Utils::mysqlDateFormat());
            $model->end_at = Carbon::parse($data["end_at"])->format(Utils::mysqlDateFormat());
        }
        
        $model->save();

        if ($data['status'] == 1) {
            $this->setactive($model->id, $model->user_id);
        }

        return $this->formatResult($model);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function editById(int $id, array $data)
    {
        // dd(preg_replace('/[^0-9]+/', '', $data['target']));
        $data['target'] = preg_replace('/[^0-9]+/', '', $data['target']);
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);

        $status_now = $model->status;
        if ($model->status == 2) {
            throw new ValidatorException(__("message.reached_goal_cant_edited"), []);
        }

        $model->title = ucwords($data["title"]);
        $model->description = @$data["description"];
        $model->target = $data["target"];
        $model->visibility = $data["visibility"];
        $model->target_visibility = $data["target_visibility"];
        if ($data['status'] == 0) {
            $model->status = $data["status"];
        }
        $model->enable_milestone = $data["enable_milestone"] ?? 0;
        if (@$data['enable_milestone']) {
            $model->start_at = Carbon::parse($data["start_at"])->format(Utils::mysqlDateFormat());
            $model->end_at = Carbon::parse($data["end_at"])->format(Utils::mysqlDateFormat());
        }
        $model->save();

        if ($status_now == 0 && $data["status"] == 1) {
            $this->setactive($model->id, $model->user_id);
        }

        return $this->formatResult($model);
    }

    public function deleteById(int $id)
    {
        $model = $this->findById($id);
        
        return $model->delete();
    }

    public function deleteCreatorGoal($goalid, $userid)
    {
        $model = $this->model->where(['id' => $goalid, 'user_id' => $userid])->inactive()->first();

        if (!$model) {
            throw new NotFoundException(__("message.notfound"), []);
        }
        
        return $model->delete();
    }

    public function getCreatorGoal($goalid, $userid, $isEdit = false)
    {        
        $model = $this->model->where(['id' => $goalid, 'user_id' => $userid])->first();

        if (!$model) {
            throw new NotFoundException(__("message.notfound"), []);
        }
        
        if ($isEdit && $model->status == 2) {
            throw new ValidatorException(__("message.reached_goal_cant_edited"), []);
        }

        return $this->formatResult($model);
    }

    public function getGoals(int $userid)
    {
        return $this->model->where("user_id", $userid);
    }

    public function getActiveGoals(int $userid)
    {
        $model = $this->model->where('user_id', $userid)->active()->first();

        return $model ? $this->formatResult($model) : [];
    }

    public function getDataTableGoals(int $userid, array $params = [])
    {
        $query = $this->getGoals($userid);

        return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('formated_visibility', function($row) {
                    return Utils::getLabelForStatus(Constant::getGoalVisibility($row->visibility));
                })
                ->addColumn('formated_status', function($row) {
                    return Utils::getLabelForStatus(Constant::getGoalStatus($row->status));
                })
                ->addColumn('formated_target', function($row) {
                    $goalProgress = $this->getGoalProgress($row->id);
                    $progress = View::make('components.goal-progress-sm', ['progress' => $goalProgress["progress"]]);

                    return __('page.goal_progress_format', [
                                'target_achieved' => $goalProgress['formated_target_achieved'], 
                                'target' => Utils::toIDR($goalProgress['target']), 
                                'progress' => $progress
                            ]);
                })
                ->addColumn('creator', function($row) {
                    return $row->user->name;
                })
                ->addColumn('milestone', function($row) {
                    if (!$row->enable_milestone) {
                        return __('page.na');
                    }

                    $start_at = $row->start_at->format(Utils::defaultDateFormat());
                    $end_at = $row->end_at->format(Utils::defaultDateFormat());

                    return $start_at ." - " .$end_at ."<br><small>" .Utils::diffDateForHumans($row->start_at, $row->end_at) ."</small>";
                })
                ->editColumn('start_at', function($row) {
                    return $row->enable_milestone ? $row->start_at->format(Utils::defaultDateFormat()) : __('page.na');
                })
                ->editColumn('end_at', function($row) {
                    return $row->enable_milestone ? $row->end_at->format(Utils::defaultDateFormat()) : __('page.na');
                })
                ->addColumn('actions', function($row) {
                    $goalid = $row->id;
                    $actions = Utils::getActionFor("view", null, '', ["id" => $goalid], ["detail"]);
                    if ($row->status != 2) $actions .= Utils::getActionFor("edit", route('goal.mygoal.edit', ['id' => $goalid]));
                    if ($row->status == 0) $actions .= Utils::getActionFor("delete", null, '', ["id" => $goalid], ["delete"]);

                    return $actions;
                })
                ->orderColumn('formated_visibility', function($query, $order) {
                    $query->orderBy('visibility', $order);
                })
                ->orderColumn('formated_status', function($query, $order) {
                    $query->orderBy('status', $order);
                })
                ->orderColumn('formated_target', function($query, $order) {
                    $query->orderBy('target', $order);
                })
                ->orderColumn('milestone', function($query, $order) {
                    $query->orderBy('start_at', $order);
                })
                ->orderColumn('creator', function($query, $order) {
                    // TODO: Change order by to name of user instead of id_user
                    $query->orderBy('user_id', $order);
                })
                ->rawColumns(['actions', 'milestone', 'formated_status', 'formated_target', 'formated_visibility'])
                ->toJson();
    }

    public function getDetail(int $id)
    {
        $model = $this->findById($id);

        return $this->formatResult($model);
    }

    public function setactive(int $id, int $user_id)
    {
        $this->validator->validateId($id);

        $this->model->where("user_id", $user_id)->where('status', '!=', 2)->update(array("status" => 0));
        $model = $this->findById($id);
        $model->status = 1;
        $model->save();
        return ["result" => __("message.goal_activate")];
    }

    public function setReached(int $id)
    {
        // TODO: Add validation: set reached if progress more than 100%
        $model = $this->findById($id);
        $model->status = 2;
        $model->save();
    }

    public function getactive($page_url)
    {
        $modelPage = $this->modelPage->where('page_url', $page_url)->first();
        return $this->model->where(array('user_id' => $modelPage->user_id, 'status' => 1))->first();
    }

    public function getGoalProgress($goalid)
    {
        $model = $this->findById($goalid);
        $sumAchieved[] = 0;
        if ($support = $model->supports->where('status', 1)) {
            $sumAchieved = $support->map(function($model) {
                return $model->invoice()->sum('creator_amount');
            })->toArray();
        }

        return [
            'target_achieved' => $target_achieved = array_sum($sumAchieved),
            'formated_target_achieved' => Utils::toIDR($target_achieved),
            'target' => $target = $model->target,
            'formated_target' => Utils::toIDR($target),
            'progress' => round( ($target_achieved / $target) * 100, 2 ),
        ];
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "creator" => $model->user->name,
            "title" => $model->title,
            "description" => $model->description,
            "target" => round($model->target),
            "formated_target" => Utils::toIDR($model->target),
            // "type" => $model->type,
            "target_visibility" => $model->target_visibility,
            "formated_target_visibility" => Constant::getGoalTargetVisibility($model->target_visibility),
            "status" => $model->status,
            "formated_status" => Constant::getGoalStatus($model->status),
            "visibility" => $model->visibility,
            "formated_visibility" => Constant::getGoalVisibility($model->visibility),
            "start_at" => $model->enable_milestone ? $model->start_at->format(Utils::defaultDateFormat()) : null,
            "end_at" => $model->enable_milestone ? $model->end_at->format(Utils::defaultDateFormat()) : null,
            "milestone" => $model->enable_milestone ? Utils::diffDateForHumans($model->start_at, $model->end_at) : __('page.na'),      // TODO: Check for overdue milestone
            "enable_milestone" => $model->enable_milestone,
            "created_at" => $model->created_at->format(Utils::defaultDateTimeFormat()),
            "updated_at" => $model->updated_at->format(Utils::defaultDateTimeFormat()),
        ];
    }

}