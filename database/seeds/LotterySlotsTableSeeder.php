<?php

use App\Acme\Models\LotterySlot;
use App\Acme\Models\LotterySlotUser;
use App\Acme\Models\User;
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

        $limit = 25;
        $faker = Faker\Factory::create();
        for ($i = 0; $i < $limit; $i++) {
            $result = [
                $faker->numberBetween(1, 100),
                $faker->numberBetween(1, 100),
                $faker->numberBetween(1, 100),
                $faker->numberBetween(1, 100),
                $faker->numberBetween(1, 100),
                $faker->numberBetween(1, 100),
            ];

            $totalParticipants = $faker->numberBetween(0, 10);
            $isActive = $i === ($limit - 1) ? 1 : 0;
            $hasWinner = !$isActive && $totalParticipants > 0 ? $faker->boolean(25) : 0;
            $totalAmount = $totalParticipants * 10;

            $lotterySlot = LotterySlot::create([
                'slot_ref' => str_random(18),
                'start_time' => date("Y-m-d H:i:s", time() - ($limit - $i) * 5 * 60),
                'end_time' => date("Y-m-d H:i:s", time() - ($limit - $i) * 10 * 60),
                'has_winner' => $hasWinner,
                'total_participants' => $totalParticipants,
                'entry_fee' => 10,
                'total_amount' => $totalAmount,
                'result' => ! $isActive ? $result : null,
                'status' => $isActive,
            ]);

            $notInArray = [1, 2, 3];
            for ($j = 0; $j < $totalParticipants; $j++) {
                $lotteryNumber = [
                    $faker->numberBetween(1, 100),
                    $faker->numberBetween(1, 100),
                    $faker->numberBetween(1, 100),
                    $faker->numberBetween(1, 100),
                    $faker->numberBetween(1, 100),
                    $faker->numberBetween(1, 100),
                ];
                $lotteryWinnerTypeId = $hasWinner && $j === 0 ? 1 : null;
                $userId = User::inRandomOrder()->whereNotIn('id', $notInArray)->first()->id;
                $notInArray[] = $userId;

                $lott = LotterySlotUser::create([
                    'lottery_slot_id' => $lotterySlot->id,
                    'user_id' => $userId,
                    'lottery_number' => $lotteryWinnerTypeId ? $result : $lotteryNumber,
                    'lottery_winner_type_id' => $lotteryWinnerTypeId,
                    'won_amount' => $lotteryWinnerTypeId ? $totalAmount * 0.9 : null,
                    'service_charge' => $lotteryWinnerTypeId ? $totalAmount * 0.1 : null
                ]);

            }
        }
    }
}