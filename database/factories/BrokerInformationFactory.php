<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\BrokerInformation;
use Faker\Generator as Faker;

$factory->define(BrokerInformation::class, function (Faker $faker) {
    static $num = 1;
    static $rand;

    return [
        "UserID" => $num++,
        "SubscriptionID" => ($rand = rand(0, 100)) >= 80 ? null : rand(1, 4),
        "SubscriptionStart" => ($rand >= 80) ? null : date('Y-m-d G:i:s')
    ];
});
