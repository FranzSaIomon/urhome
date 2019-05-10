<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\UserDocument;
use Faker\Generator as Faker;

$factory->define(UserDocument::class, function (Faker $faker) {
    return [
        "ImageAttachment1" => $faker->imageUrl(),
        "ImageAttachment2" => $faker->imageUrl(),
        "FileAttachment1" => "http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.105.3184&rep=rep1&type=pdf",
        "FileAttachment2" => "http://citeseerx.ist.psu.edu/viewdoc/download?doi=10.1.1.105.3184&rep=rep1&type=pdf",
        "UserID" => rand(0, 10)
    ];
});
