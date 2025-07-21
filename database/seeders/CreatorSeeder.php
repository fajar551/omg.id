<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Src\Helpers\Constant;
use Illuminate\Database\Seeder;
use DB;

class CreatorSeeder extends Seeder
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

            $gender = ['male', 'female'];
            $faker = Factory::create('id_ID');
            
            // Create Dummy User Creator 
            for ($i = 1; $i <= Constant::SEEDER_LIMIT; $i++) { 
                $user = User::updateOrCreate(
                    ['id' => $i],
                    [
                        'id' => $i,
                        'name' => "Creator $i",
                        'username' => "creator$i",
                        'email' => "creator$i@omg.id",
                        'password' => bcrypt('secret'), 
                        'status' => 1,
                        'gender' => $gender[$faker->numberBetween(0, 1)],
                        'phone_number' => $faker->e164PhoneNumber,
                        'email_verified_at' => now(),
                        'address' => $faker->streetAddress,
                        'address_city' => $faker->city,
                        'address_province' => $faker->state,
                        'address_district' => $faker->stateAbbr,
                    ],
                );

                $user->syncRoles(['creator']);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
