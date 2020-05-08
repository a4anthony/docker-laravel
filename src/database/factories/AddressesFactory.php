<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MelaMart\Entities\Address;
use Faker\Generator as Faker;



if (!function_exists('autoIncrement')) {
    function autoIncrement()
    {
        for ($i = 0; $i < 1000; $i++) {
            yield $i;
        }
    }
}

$autoIncrement = autoIncrement();

$factory->define(
    Address::class,
    function (Faker $faker) use ($autoIncrement) {
        $autoIncrement->next();
        return [
            'first_name' => $faker->name,
            'last_name' => $faker->name,
            'phone' => $faker->phoneNumber,
            'address_number' => 'Plot' . rand(20, 150),
            'address_address' => $faker->streetAddress,
            'address_longitude' => 1,
            'address_latitude' => 1,
            'address_id' => $autoIncrement->current(),
            'address_additional' => $faker->sentence,
        ];
    }
);

/**
 * AutoIncrement Function
 *
 * @return void
 * @author Anthony Akro <anthonygakro@gmail.com> [a4anthony]
 */
