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
        //===============Settings==================
        // Seed Settings
        $this->call(SettingsTableSeeder::class);

        //===============Currency==================
        $this->call(CurrencyTableSeeder::class);

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

        //===============Lottery===================
        // Seed Lottery Winner Types
        $this->call(LotterySlotsTableSeeder::class);
        $this->call(LotteryWinnerTypesTableSeeder::class);

        //===============Wallet====================
        $this->call(WalletTableSeeder::class);

        //===============Withdraw Gateway====================
        $this->call(WithdrawGatewayTableSeeder::class);

        //===============Page ====================
        $this->call(PageTableSeeder::class);

        //===============Page ====================
        $this->call(SeoTableSeeder::class);

    }
}
