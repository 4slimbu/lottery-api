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
                'name' => 'jackpot',
                'label' => 'Jackpot',
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'five_digit',
                'label' => 'Five Digit',
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => 'four_digit',
                'label' => 'Four digit',
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}