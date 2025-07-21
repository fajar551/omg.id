<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\User;
use App\Src\Services\Eloquent\GoalService;
use Faker\Factory;
use Illuminate\Database\Seeder;
use DB;

class SupportSeeder extends Seeder
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
            $users = User::role('creator')->get()->pluck("id");
            $extra = compact("faker", "users");

            $invoices = Invoice::all();
            $invoices->each(function($model, $key) use($extra) {
                extract($extra);
                $rand1 = $faker->numberBetween(0, count($users) - 1);
                $rand2 = $faker->numberBetween(0, count($users) - 1);

                while ($rand1 == $rand2) {
                    $rand2 = $faker->numberBetween(0, count($users) - 1);
                }

                $creatorId = $users[$rand1];
                $supporterId = $users[$rand2];
                $goalId = GoalService::getInstance()->getActiveGoals($creatorId)["id"] ?? null;

                $model->support()->updateOrCreate(
                    ['invoice_id' => $model->id],
                    [
                        'creator_id' => $creatorId,
                        'supporter_id' => $key%5 == 0 ? null : $supporterId,
                        'goal_id' => $goalId,
                        'name' => $faker->name,
                        'email' => $faker->email,
                        'message' => $faker->sentence(6, true),
                        'type' => 1,
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
