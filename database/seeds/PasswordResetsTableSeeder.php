<?php

use Illuminate\Database\Seeder;

class PasswordResetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('password_resets')->delete();
        
        \DB::table('password_resets')->insert(array (
            0 => 
            array (
                'id' => 2,
                'email' => 'responsivesudip@gmail.com',
                'token' => '$2y$10$8e7PG.mrqsxRzGL9M..mS.jwQMJ/MlOeSoC14L0f2Crj.UaFS8Kaa',
                'created_at' => '2019-05-10 04:27:24',
            ),
        ));
        
        
    }
}