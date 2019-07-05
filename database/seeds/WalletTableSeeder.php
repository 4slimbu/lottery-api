<?php

use App\Acme\Models\LotterySlot;
use App\Acme\Models\LotterySlotUser;
use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->truncate();

        $users = User::get();

        $faker = Faker\Factory::create();

        foreach ($users as $user) {
            $won = $faker->randomElement([0, 0, 50, 75, 100, 125, 150]);
            $pendingWithdraw = $faker->randomElement([0, 0, 50, 75, 100, 125, 150]);
            $deposit = 10000;

            Wallet::create([
                'user_id' => $user->id,
                'won' => $won,
                'pending_withdraw' => $pendingWithdraw,
                'deposit' => $deposit,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

        }
    }
}