<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RolePermissionSeeder extends Seeder
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

            // Create role
            $roles = config('permission.roles');
            foreach ($roles as $role) {
                Role::updateOrCreate(
                    ['name' => $role],
                    ['guard_name' => 'web']
                );
            }

            // Create permissions
            $permissions = config('permission.permissions.admin');
            foreach ($permissions as $permission) {
                Permission::updateOrCreate(
                    ['name' => $permission],
                    ['guard_name' => 'web']
                );
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
