<?php

use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Models\WithdrawGateway;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    $withdrawableAmount = $faker->randomElement([0, 0, 50, 75, 100, 125, 150]);
    $pendingWithdrawableAmount = $faker->randomElement([0, 0, 50, 75, 100, 125, 150]);
    $usableAmount = $withdrawableAmount + $faker->randomElement([0, 0, 15, 25, 50, 75, 100]);

    $wallet = Wallet::create([
        'withdrawable_amount' => $withdrawableAmount,
        'pending_withdraw_amount' => $pendingWithdrawableAmount,
        'usable_amount' => $usableAmount,
        'total_amount' => $usableAmount + $pendingWithdrawableAmount,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ]);

    $withdrawGateway = WithdrawGateway::create([
        'gateway' => 'bitcoin',
        'gateway_username' => $faker->unique()->safeEmail,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ]);

    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'username' => $faker->unique()->userName,
        'gender' => $faker->randomElement(['male', 'female']),
        'contact_number' => $faker->phoneNumber,
        'verified' => $faker->boolean(90),
        'is_active' => $faker->boolean(90),
        'withdraw_gateway_id' => $withdrawGateway->id,
        'wallet_id' => $wallet->id,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ];
});
