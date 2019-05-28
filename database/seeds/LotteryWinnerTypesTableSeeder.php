<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotteryWinnerTypesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lottery_winner_types')->truncate();

        DB::table('lottery_winner_types')->insert([
            [
                'name' => 'whole_match',
                'label' => 'Whole Match',
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'row_match',
                'label' => 'Row Match',
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'diagonal_match',
                'label' => 'Diagonal Match',
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}