<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //==========Roles and Permissions==========
        // Seed Permissions
        $this->call([CorePermissionsTableSeeder::class]);

        // Seed Roles
        $this->call([CoreRolesTableSeeder::class]);

        // Seed Roles Permissions
        $this->call([CorePermissionRoleTableSeeder::class]);

        //===========User and Roles ===============
        // Seed Users
        $this->call([UsersTableSeeder::class]);

        // Seed User Roles
        $this->call([CoreRoleUserTableSeeder::class]);

        //===============Settings==================
        // Seed Settings
        $this->call(SettingsTableSeeder::class);

        //===============Lottery===================
        // Seed Lottery Winner Types
        $this->call(LotteryWinnerTypesTableSeeder::class);

        //===============Wallet====================
    }
}
