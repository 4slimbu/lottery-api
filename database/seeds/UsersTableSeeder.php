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
        DB::table('core_users')->insert(array(
            array(
                'first_name' => 'Sudip',
                'last_name' => 'Limbu',
                'email' => 'sudip@gmail.com',
                'username' => 'sudip',
                'gender' => 'male',
                'contact_number' => '92839238',
                'password' => bcrypt('password'),
                'verified' => 1,
                'is_active' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ),
        ));

    }
}
