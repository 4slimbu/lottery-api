<?php

use App\Acme\Models\LotterySlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LotterySlotsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lottery_slots')->truncate();

        LotterySlot::insert([
            [
                'slot_ref' => str_random(18),
                'start_time' => date("Y-m-d H:i:s", time() - 15 * 60),
                'end_time' => date("Y-m-d H:i:s", time() - 10 * 60),
                'has_winner' => 1,
                'total_participants' => 23,
                'currency' => 'USD',
                'entry_fee' => '1',
                'total_amount' => 1000,
                'result' => '[62, 84, 83, 12, 38, 81]',
                'status' => 0,
            ],
            [
                'slot_ref' => str_random(18),
                'start_time' => date("Y-m-d H:i:s", time() - 10 * 60),
                'end_time' => date("Y-m-d H:i:s", time() - 5 * 60),
                'has_winner' => 1,
                'total_participants' => 46,
                'currency' => 'USD',
                'entry_fee' => '1',
                'total_amount' => 1000,
                'result' => '[23, 16, 83, 74, 82, 19]',
                'status' => 0,
            ],
            [
                'slot_ref' => str_random(18),
                'start_time' => date("Y-m-d H:i:s", time() - 5 * 60),
                'end_time' => date("Y-m-d H:i:s", time()),
                'has_winner' => 0,
                'total_participants' => 75,
                'currency' => 'USD',
                'entry_fee' => '1',
                'total_amount' => 1000,
                'result' => '[12, 23, 56, 13, 27, 18]',
                'status' => 0,
            ],
            [
                'slot_ref' => str_random(18),
                'start_time' => date("Y-m-d H:i:s", time()),
                'end_time' => date("Y-m-d H:i:s", time() + 5 * 60),
                'has_winner' => 1,
                'total_participants' => 50,
                'currency' => 'USD',
                'entry_fee' => '1',
                'total_amount' => 2000,
                'result' => '[2, 25, 17, 10, 59, 78]',
                'status' => 1,
            ],
        ]);
    }
}