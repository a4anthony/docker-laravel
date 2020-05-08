<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MelaMart\Entities\Image;
use Faker\Generator as Faker;

$factory->define(
    Image::class,
    function (Faker $faker) {
        $fakerImage = [
            '1578755939_1174134661peak.jpg', '1578755939_1243560826flakes.jpg',
            '1578755777_1852970487milo.jpg', '1578755939_1391526890nivea.jpg',
            '1576001949_1943094487perf.jpg'
        ];

        $imagesLink = '/productImages/' . $faker->randomElement($fakerImage);
        return [
            //'image_link' => $imagesLink,
        ];
    }
);
