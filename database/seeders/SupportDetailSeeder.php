<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Support;
use Faker\Factory;
use Illuminate\Database\Seeder;
use DB;

class SupportDetailSeeder extends Seeder
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
            $items = Item::get()->toArray();
            $extra = compact("faker", "items");

            $supports = Support::all();
            $supports->each(function($model, $key) use($extra) {
                extract($extra);

                $rand = $faker->numberBetween(0, count($items) - 1);
                $itemId = $items[$rand]["id"];
                $itemPrice = $items[$rand]["price"];

                $model->details()->updateOrCreate(
                    ['support_id' => $model->id],
                    [
                        'item_id' => $itemId,
                        'price' => $itemPrice,
                        'qty' => $qty = $faker->numberBetween(1, 10),
                        'total' => $qty * $itemPrice,
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
