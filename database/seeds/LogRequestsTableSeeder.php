<?php

use Illuminate\Database\Seeder;

class LogRequestsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('log_requests')->delete();
        
        
        
    }
}