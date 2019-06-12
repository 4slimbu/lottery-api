<?php

use App\Acme\Models\LotterySlot;
use App\Acme\Models\LotterySlotUser;
use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Models\WithdrawGateway;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WithdrawGatewayTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('withdraw_gateway')->truncate();

        $users = User::whereNotIn('id', [1, 2, 3])->get();
        $faker = Faker\Factory::create();

        foreach ($users as $user) {
            $withdrawGateway = WithdrawGateway::create([
                'user_id' => $user->id,
                'gateway' => 'bitcoin',
                'gateway_username' => $faker->unique()->safeEmail,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

        }
    }
}