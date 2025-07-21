<?php

namespace App\Src\Services\Eloquent;

use App\Models\UserWidget;
use App\Models\Widget;
use App\Src\Helpers\Constant;

class UserWidgetService {

    protected $model;
    protected $modelWidget;

    public function __construct(UserWidget $model, Widget $modelWidget) {
        $this->model = $model;
        $this->modelWidget = $modelWidget;
    }

    public function getlist ()
    {
        $settingService = SettingService::getInstance();
        \DB::statement("SET sql_mode = '' ");
        $list = $this->model->with([
            'users' => function ($q) {
                $q->select("id", "name", "profile_picture");
            },
        ])
            ->where("is_used", 1)
            ->groupBy('user_id')
            ->get()->map(function ($model) use ($settingService) {
                return array(
                    'name' => $model->users->name,
                    'profile_picture' => route("api.profile.preview", ["file_name" => $model->users->profile_picture ?: Constant::UNKNOWN_STATUS]),
                    'stream_url' => $settingService->get('stream_url', null, $model->user_id)
                );
            });

        return $list;
    }

    public function setstreaming(array $data)
    {
        $modelWidget = $this->modelWidget->where('key', $data['key'])->first();
        $result = $this->model->updateOrCreate([
            "user_id" => $data['user_id'],
            "widget_id" => $modelWidget->id
        ],
        [
            "is_used" => $data['is_used']
        ]);

        $settingService = SettingService::getInstance();
        \DB::statement("SET sql_mode = '' ");
        $list = $this->model->with(['users' => function ($q) {
                                        $q->select("id","name", "profile_picture");
                                    },
                                ])
                            ->where("is_used", 1)
                            ->groupBy('user_id')
                            ->get()->map(function($model) use($settingService) {
                            return array(
                                'name' => $model->users->name,
                                'profile_picture' => route("api.profile.preview", ["file_name" => $model->users->profile_picture ?: Constant::UNKNOWN_STATUS]),
                                'stream_url' => $settingService->get('stream_url', null, $model->user_id)
                            );
                        });
        
        event(new \App\Events\StreamCreator($list->toArray()));

        return $list;
    }
}
