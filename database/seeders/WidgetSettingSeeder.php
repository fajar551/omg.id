<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Widget;
use App\Src\Services\Eloquent\WidgetService;
use App\Src\Validators\WidgetValidator;
use Illuminate\Database\Seeder;
use DB;

class WidgetSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();

            $service = WidgetService::getInstance();
            $user = User::role('creator')->find(1);
            $overlays =  $service->getAvailableWidgets("overlay");
            $webEmbeds =  $service->getAvailableWidgets("web_embed");

            if ($user) {
                $userid = $user->id; 

                // Seed widget overlay settings
                $service->setWidgetType("overlay");
                foreach ($overlays as $overlay) {
                    $key = $overlay["key"];
                    $service->seedSetting([
                        "user_id" => $userid,
                        "key" => $key,
                    ]);
                }

                // Seed widget web embed settings
                $service->setWidgetType("web_embed");
                foreach ($webEmbeds as $embed) {
                    $key = $embed["key"];
                    $service->seedSetting([
                        "user_id" => $userid,
                        "key" => $key,
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            
            throw $th;
        }
    }
}
