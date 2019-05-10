<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        "Name" => $faker->sentence(),
        "Description" => $faker->sentences(),
        "Developer" => $faker->company(),
        'LotNo' => $faker->randomNumber(4),
        'Street' => $faker->streetName(),
        'City' => $faker->city(),
        'Country' => $faker->country(),
        "YearBuilt" => $faker->year(),
        "FloorArea" => rand(0, 100),
        "LotArea" => rand(0, 100),
        "Price" => $faker->randomNumber(8),
        "NumberOfBedrooms" => rand(0, 20),
        "NumberOfBathrooms" => rand(0, 20),
        "CapacityOfGarage" => rand(0, 20),
        "Verified" => rand(0, 1),
        "UserID" => rand(0, 20),
        "ListingTypeID" => rand(0, 20),
        "StatusID" => rand(0, 1),
        "PropertyTypeID" => rand(0, 20)
    ];
});
