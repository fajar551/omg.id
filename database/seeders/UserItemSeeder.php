<?php

namespace Database\Seeders;

use App\Models\User;
use App\Src\Services\Eloquent\ItemService;
use Illuminate\Database\Seeder;
use DB;

class UserItemSeeder extends Seeder
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

            User::role('creator')->get()->map(function($model) {
                $model->items()->delete();
                $model->items()->withTrashed()->update(['deleted_at' => null]);
                ItemService::getInstance()->setCreatorDefaultItem($model->id);
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
