<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\PropertyAmenity;
use Faker\Generator as Faker;

$factory->define(PropertyAmenity::class, function (Faker $faker) {
    return [
        'PropertyID' => rand(1, 100),
        'AmenityID' => rand(1, 10)
    ];
});
