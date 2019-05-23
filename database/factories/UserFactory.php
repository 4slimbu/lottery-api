<?php

use App\Acme\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('Password1'),
        'remember_token' => str_random(10),
    ];
});
