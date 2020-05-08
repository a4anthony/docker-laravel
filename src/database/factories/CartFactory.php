<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MelaMart\Entities\Cart;
use Faker\Generator as Faker;

$factory->define(
    Cart::class,
    function (Faker $faker) {
        return [
            //'quantity' => 1,
        ];
    }
);
