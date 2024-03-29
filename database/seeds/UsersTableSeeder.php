<?php

use App\Acme\Models\User;
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

        $faker = Faker\Factory::create();

        DB::table('core_users')->truncate();

        DB::table('core_users')->insert(array(
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'superadmin@gmail.com',
                'username' => 'superadmin',
                'gender' => 'male',
                'contact_number' => '92839238',
                'password' => bcrypt('mictesting@123'),
                'verified' => 1,
                'is_active' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'John',
                'email' => 'admin@gmail.com',
                'username' => 'admin',
                'gender' => 'male',
                'contact_number' => '92839238',
                'password' => bcrypt('mictesting@123'),
                'verified' => 1,
                'is_active' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'first_name' => 'Player',
                'last_name' => 'John',
                'email' => 'player@gmail.com',
                'username' => 'player',
                'gender' => 'male',
                'contact_number' => '92839238',
                'password' => bcrypt('mictesting@123'),
                'verified' => 1,
                'is_active' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'first_name' => 'Sudip',
                'last_name' => 'Limbu',
                'email' => 'responsivesudip@gmail.com',
                'username' => 'sudiplimbu',
                'gender' => 'male',
                'contact_number' => '92839238',
                'password' => bcrypt('mictesting@123'),
                'verified' => 1,
                'is_active' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]
        ));

        // Add extra random users
        factory(User::class, 500)->create();
    }

}
