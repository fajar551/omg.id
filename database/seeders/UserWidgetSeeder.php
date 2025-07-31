<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Widget;
use Illuminate\Database\Seeder;
use DB;

class UserWidgetSeeder extends Seeder
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

            $widget = Widget::get()->pluck("id");
            $users = User::role('creator')->get();
            $users->each(function($model, $key) use($widget) {
                $model->widgets()->sync($widget);
            });
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
