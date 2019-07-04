<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        "UserID" => rand(1, 10),
        "Action" => $faker->sentence()
    ];
});
