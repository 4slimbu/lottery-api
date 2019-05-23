<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            array(
                'account_id' => 1,
                'name' => 'Ramesh Maharjan',
                'email' => 'maharjanrams@gmail.com',
                'password' => bcrypt('newmoon123'),
                'remember_token' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'verified' => 1,
            ),
        ));

    }
}
