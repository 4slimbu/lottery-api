<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoreRolesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_roles')->truncate();

        DB::table('core_roles')->insert([
            [
                'name' => 'super_admin',
                'label' => 'Super Admin',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'admin',
                'label' => 'Admin',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'player',
                'label' => 'Player',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}