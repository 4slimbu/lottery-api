<?php

use App\Acme\Models\User;
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
        DB::table('core_users')->truncate();

        $this->call([UsersTableSeeder::class]);
        factory(User::class, 50)->create();
//        $this->call(CommentsTableSeeder::class);
//        $this->call(CorePermissionsTableSeeder::class);
//        $this->call(CorePermissionRoleTableSeeder::class);
//        $this->call(CoreRolesTableSeeder::class);
//        $this->call(CoreRoleUserTableSeeder::class);
//        $this->call(CoreUsersTableSeeder::class);
//        $this->call(MediaTableSeeder::class);
//        $this->call(PasswordResetsTableSeeder::class);
//        $this->call(PostsTableSeeder::class);
    }
}
