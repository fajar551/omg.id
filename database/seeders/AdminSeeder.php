<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use App\Src\Helpers\Constant;
use Illuminate\Database\Seeder;
use DB;

class AdminSeeder extends Seeder
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

            $permissions = config('permission.permissions.admin');
            $gender = ['male', 'female'];
            $faker = Factory::create('id_ID');
            
            // User Admin Seeder
            for ($i = Constant::SEEDER_LIMIT + 1; $i <= Constant::SEEDER_LIMIT + 3; $i++) { 
                $user = User::updateOrCreate(
                    ['id' => $i],
                    [
                        'id' => $i,
                        'name' => "Admin $i",
                        'username' => "admin$i",
                        'email' => "admin$i@omg.id",
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

                $user->syncRoles(['admin', 'moderator']);
                $user->syncPermissions($permissions);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
