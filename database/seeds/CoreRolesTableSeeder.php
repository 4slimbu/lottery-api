<?php

use Illuminate\Database\Seeder;

class CoreRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('core_roles')->delete();
        
        \DB::table('core_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'label' => 'Admin',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}