<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\User;
use App\Src\Helpers\Constant;
use Illuminate\Support\Facades\Schema;
use App\Src\Services\Eloquent\ItemService;
use Illuminate\Database\Seeder;
use Faker\Factory;
use DB;

class ContentSeeder extends Seeder
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
            // Truncate all data to seed fresh data 
            Schema::disableForeignKeyConstraints();
            Content::truncate();
            Schema::enableForeignKeyConstraints();

            $faker = Factory::create('id_ID');
            $users = User::role('creator')->get()->pluck("id");
            
            for ($i = 0; $i < count($users); $i++) { 
                $userid = $users[$i];
                $item = ItemService::getInstance()->getActiveItems($userid);

                for ($j = 0; $j < Constant::SEEDER_LIMIT ; $j++) { 
                    Content::create([
                        'user_id' => $userid, 
                        'title' => $faker->sentence(5, true),
                        'content' => $faker->sentence(150, true),
                        'status' => $faker->numberBetween(0, 1),
                        'sensitive_content' => $faker->numberBetween(0, 1),
                        'qty' => $qty = $faker->numberBetween(0, 10),
                        'item_id' => $qty > 0 ? @$item[0]['id'] : null,
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
