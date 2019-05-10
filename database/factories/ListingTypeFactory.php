<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\ListingType;
use Faker\Generator as Faker;

$factory->define(ListingType::class, function (Faker $faker) {
    return [
        "ListingType" => (rand(0, 1) == 0 ? 'rent' : 'sale')
    ];
});
