<?php

use Illuminate\Database\Seeder;

class CoreLocationTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('core_location_types')->delete();
        
        \DB::table('core_location_types')->insert(array (
            0 => 
            array (
                'type' => 'AREA',
                'priority' => 20,
            ),
            1 => 
            array (
                'type' => 'COUNTRY',
                'priority' => 50,
            ),
            2 => 
            array (
                'type' => 'REGION',
                'priority' => 30,
            ),
            3 => 
            array (
                'type' => 'STATE',
                'priority' => 40,
            ),
            4 => 
            array (
                'type' => 'SUBURB',
                'priority' => 10,
            ),
        ));
        
        
    }
}