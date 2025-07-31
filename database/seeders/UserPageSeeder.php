<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;

class UserPageSeeder extends Seeder
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

            $users = User::role('creator')->get();
            $users->each(function($model, $key) {
                $model->page()->updateOrCreate(
                    ['user_id' => $model->id],
                    [
                        "name" => "Page Creator " .(++$key),
                        'page_url' => "creator" .($key),
                        'page_message' => __("message.default_page_message"),
                        'status' => 1,
                    ]
                );
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
