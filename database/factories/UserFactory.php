<?php

use App\Acme\Models\User;
use App\Acme\Models\Wallet;
use App\Acme\Models\WithdrawGateway;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'username' => $faker->unique()->userName,
        'nickname' => $faker->unique()->userName,
        'gender' => $faker->randomElement(['male', 'female']),
        'contact_number' => $faker->phoneNumber,
        'verified' => $faker->boolean(90),
        'is_active' => $faker->boolean(90),
        'is_bot' => $faker->boolean(90),
        'free_games' => 5,
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ];
});
