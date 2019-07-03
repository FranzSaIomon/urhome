<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Feedback;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    static $num = 1;
    static $random;

    return [
        'Votes' => ($random = rand(0, 500)) ? $random : 0,
        'Feedback' => $random * rand(0, 5),
        'PropertyID' => $num++,
    ];
});
