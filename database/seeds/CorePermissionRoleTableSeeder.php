<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CorePermissionRoleTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_permission_role')->truncate();

        // Seed permissions for Super Admin
        $superAdmin = DB::table('core_roles')->select('id')->where('name', 'super_admin')->first();
        $allPermissions = DB::table('core_permissions')->select('id')->get();

        foreach ($allPermissions as $permission) {
            DB::table('core_permission_role')->insert([
                'role_id' => $superAdmin->id,
                'permission_id' => $permission->id
            ]);
        }

        // Seed permissions for Admin
        $admin = DB::table('core_roles')->select('id')->where('name', 'admin')->first();
        $adminPermissions = DB::table('core_permissions')->select('id')->whereNotIn('name', [
            'getPermissions', 'createPermission', 'updatePermission', 'destroyPermission'
        ])->get();

        foreach ($adminPermissions as $permission) {
            DB::table('core_permission_role')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permission->id
            ]);
        }

        // Seed permissions for Player
        $admin = DB::table('core_roles')->select('id')->where('name', 'player')->first();
        $adminPermissions = DB::table('core_permissions')->select('id')->whereIn('name', [
            'read_self', 'edit_self', 'delete_self'
        ])->get();

        foreach ($adminPermissions as $permission) {
            DB::table('core_permission_role')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permission->id
            ]);
        }
    }
}