<?php

use App\Acme\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'withdrawable_amount' => 50,
        'pending_withdraw_amount' => 100,
        'usable_amount' => 1000,
        'total_amount' => 1100,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ];
});
