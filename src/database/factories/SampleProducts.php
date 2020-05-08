<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MelaMart\Entities\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;




$factory->define(
    Product::class,
    function (Faker $faker) {
        $inital_price = rand(5000, 15000);
        $discount = rand(5, 45);
        $total_price = (int) ($inital_price * $discount / 100);
        $returns = '7 days';
        $delivery = '24 - 48 hours';
        $brand = 'random brand';
        $title = $faker->text(50);
        return [
            'barcode' => rand(1000000, 1500000),
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'brief_description' => $faker->text(200),
            'features' => $faker->text(500),
            'specifications' => $faker->text(500),
            'brand' => $brand,
            'initial_price' => $inital_price,
            'discount' => $discount,
            'quantity' => rand(0, 30),
            'total_price' => $total_price,
            'returns' => $returns,
            'delivery' => $delivery,
            'live' => rand(0, 1)
        ];
    }
);
