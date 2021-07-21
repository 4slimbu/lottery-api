<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoreRoleUserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('core_role_user')->truncate();

        DB::table('core_role_user')->insert([
            [
                'user_id' => '1',
                'role_id' => '1',
            ],
            [
                'user_id' => '2',
                'role_id' => '2',
            ],
            [
                'user_id' => '3',
                'role_id' => '3',
            ],
        ]);

        // Assign all other users player role
        // we are skipping (1, 2, 3) because we already have hard coded 3 users roles
        $users = DB::table('core_users')->select('id')->whereNotIn('id', [1, 2, 3])->get();

        foreach($users as $user) {
            DB::table('core_role_user')->insert([
                'user_id' => $user->id,
                'role_id' => 3
            ]);
        }
    }
}