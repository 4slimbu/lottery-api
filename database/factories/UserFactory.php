<?php

use App\Acme\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('password'),
        'remember_token' => str_random(10),
        'username' => $faker->unique()->userName,
        'gender' => $faker->randomElement(['male', 'female']),
        'contact_number' => $faker->phoneNumber,
        'profile_pic' => $faker->imageUrl($width = 100, $height = 100),
        'verified' => $faker->boolean(90),
        'is_active' => $faker->boolean(90),
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
    ];
});
