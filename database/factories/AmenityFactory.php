<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Amenity;
use Faker\Generator as Faker;

$factory->define(Amenity::class, function (Faker $faker) {
    return [
        'AmenityName' => $faker->words(2, true)
    ];
});
