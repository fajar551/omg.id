<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use Illuminate\Database\Seeder;
use DB;

class ItemSeeder extends Seeder
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

            $startPrice = 5000;
            for ($i = 1; $i <= 2; $i++) { 
                $price = $startPrice * $i;

                Item::updateOrCreate(
                    ['id' => $i],
                    [
                        'name' => Utils::toIDR($price), 
                        'icon' => "coin.png", 
                        'description' => "Cash Money", 
                        'price' => $price,
                        'is_default' => 1,
                        'deleted_at' => null,
                    ],
                );
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
