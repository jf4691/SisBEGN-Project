<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    $gender = $faker->randomElement(['Masculino', 'Femenino']);
    //$level = $faker->randomElement(['7', '8', '9', '10', '11', '12']);
    $photo = $faker->randomElement(['cara1.jpg', 'h.jpg', 'cara2.jpg', 'j.jpg', 'cara4.png', 'k.jpg', 'b.jpg', 'i.jpg']);
    return [
        'role_id' => '1',//$faker->numberBetween($min=2, $max=3),
        'name' => $faker->firstName($gender),
        'lastName' => $faker->lastName,
        'idCard' => $faker->numberBetween($min=1700000000, $max=1799999999),
        'birthDate' => $faker->date,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'gender' => 'Masculino',
        'phone' => $faker->numberBetween($min=984111111, $max=999999999),
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'photo' => $photo,
        'status' => '1',
        'remember_token' => Str::random(10),
    ];
});
