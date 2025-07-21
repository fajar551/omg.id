<?php

namespace Database\Seeders;

use App\Models\Widget;
use App\Src\Services\Eloquent\WidgetService;
use App\Src\Validators\WidgetValidator;
use Illuminate\Database\Seeder;
use DB;

class WidgetSeeder extends Seeder
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

            $data = [
                [
                    'name' => 'Notification',
                    'key' => 'notification',
                    'type' => 'overlay',
                ],
                [
                    'name' => 'Leaderboard',
                    'key' => 'leaderboard',
                    'type' => 'overlay',
                ],
                [
                    'name' => 'Last Supporter',
                    'key' => 'lastsupporter',
                    'type' => 'overlay',
                ],
                [
                    'name' => 'Target / Goal',
                    'key' => 'goal',
                    'type' => 'overlay',
                ],
                [
                    'name' => 'Running Text',
                    'key' => 'marquee',
                    'type' => 'overlay',
                ],
                [
                    'name' => 'QR Code',
                    'key' => 'qrcode',
                    'type' => 'overlay',
                ],
                [
                    'name' => 'Custom Button',
                    'key' => 'custom_button',
                    'type' => 'web_embed',
                ],
                [
                    'name' => 'Static Button',
                    'key' => 'static_button',
                    'type' => 'web_embed',
                ],
            ];

            $service = WidgetService::getInstance();

            foreach ($data as $value) {
                $service->updateOrCreate($value);
            }
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            
            throw $th;
        }
    }
}
