<?php

namespace Database\Seeders;

use App\Models\User;
use App\Src\Helpers\Utils;
use App\Src\Services\Eloquent\GoalService;
use Illuminate\Database\Seeder;
use DB;
use Faker\Factory;

class GoalSeeder extends Seeder
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

            $faker = Factory::create('id_ID');

            User::role('creator')->get()->map(function($model) use($faker) {
                $model->goal()->delete();

                GoalService::getInstance()->store([
                    "user_id" => $model->id,
                    "title" => ucwords($faker->sentence(3, true)),
                    "description" => $faker->text($faker->numberBetween(50, 150)),
                    "target" => $faker->numberBetween(500000, 10000000),
                    "visibility" => $faker->numberBetween(1, 3),
                    "target_visibility" => 1,
                    "status" => 1,
                    "enable_milestone" => 1,
                    "start_at" => now()->format(Utils::defaultDateFormat()),
                    "end_at" => now()->addMonths($faker->numberBetween(6, 12))->format(Utils::defaultDateFormat()),
                ]);
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
