<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    return [
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),

        'FirstName' => $faker->firstName(),
        'LastName' => $faker->lastName(),
        'ContactNo' => $faker->regexify("^(09|\+639)\d{9}$"),
        'BirthDate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'LotNo' => $faker->randomNumber(4),
        'Street' => $faker->streetName(),
        'City' => $faker->city(),
        'Country' => $faker->country(),
        'Status' => rand(0, 1),
        'ProfileImage' => $faker->imageUrl(),
        'UserType' => rand(1, 3) // foreign key
    ];
});
