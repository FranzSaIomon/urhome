<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        "Name" => $faker->sentence(),
        "Description" => $faker->sentences(4, true),
        "Developer" => $faker->company(),
        'LotNo' => $faker->randomNumber(4),
        'Street' => $faker->streetName(),
        'City' => $faker->city(),
        'Country' => $faker->country(),
        "YearBuilt" => $faker->year(),
        "FloorArea" => rand(0, 100),
        "LotArea" => rand(0, 100),
        "Price" => $faker->numberBetween(100, 100000000),
        "NumberOfBedrooms" => rand(0, 20),
        "NumberOfBathrooms" => rand(0, 20),
        "CapacityOfGarage" => rand(0, 20),
        "Verified" => rand(0, 1),
        "UserID" => rand(1, 10),
        "ListingTypeID" => rand(1, 2),
        "StatusID" => rand(1, 4),
        "PropertyTypeID" => rand(1, 5)
    ];
});
