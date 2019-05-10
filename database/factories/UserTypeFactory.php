<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\UserType;
use Faker\Generator as Faker;

$factory->define(UserType::class, function (Faker $faker) {
    $type = [
        "Client", "Broker", "Admin"
    ];
    return [
        "UserType" => $type[rand(0, 2)]
    ];
});
