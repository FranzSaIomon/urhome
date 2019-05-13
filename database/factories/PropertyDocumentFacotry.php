<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\PropertyDocument;
use Faker\Generator as Faker;

$factory->define(PropertyDocument::class, function (Faker $faker) {
    return [
        "Images" => "[" . $faker->imageUrl() . "]",
        "Files" => "[http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.105.3184&rep=rep1&type=pdf]",
        "PropertyID" => rand(1, 100)
    ];
});
