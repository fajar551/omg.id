<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use DB;

class UserBalanceSeeder extends Seeder
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
            $users = User::role('creator')->get();
            $users->each(function($model, $key) use($faker) {
                $model->balance()->updateOrCreate(
                    ['user_id' => $model->id],
                    [
                        'active' => $faker->numberBetween(0, 1000000),
                        'pending' => $faker->numberBetween(0, 1000000)
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
