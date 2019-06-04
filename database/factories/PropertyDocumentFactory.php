<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\PropertyDocument;
use Faker\Generator as Faker;

$factory->define(PropertyDocument::class, function (Faker $faker){
    static $number = 1;
    return [
        "Images" => ["regular" => 
                        [$faker->imageUrl(300,300, 'cats'),
                         $faker->imageUrl(300,300, 'cats'),
                         $faker->imageUrl(300,300, 'cats')],
                     "3d" => 
                        [
                            "bathroom" => "img/properties/sample.jpg"
                        ]
                    ],
        "Files" => ['http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.105.3184&rep=rep1&type=pdf'],
        "PropertyID" => $number++
    ];
});
