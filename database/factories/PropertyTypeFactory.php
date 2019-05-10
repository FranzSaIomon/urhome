<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\PropertyType;
use Faker\Generator as Faker;

$factory->define(PropertyType::class, function (Faker $faker) {
    $properties = [
        'Townhouse',
        'House',
        'Service Apartment',
        'Condominium',
        'Condotel'
    ];
    
    return [
        'PropertyType' => $properties[rand(0, 4)]
    ];
});
