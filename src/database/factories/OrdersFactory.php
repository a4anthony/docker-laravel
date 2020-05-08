<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MelaMart\Entities\Order;
use App\MelaMart\Entities\Product;
use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(
    Order::class,
    function (Faker $faker) {
        $product = Product::inRandomOrder()->select('id', 'total_price')->first();
        return [
            'user_id' => rand(1, 10),
            'product_id' => $product->id,
            'price' => $product->total_price,
            'reference' => Str::slug($faker->word, '-'),
            'address' =>  $faker->streetAddress,
            'quantity' => rand(1, 10),
            'transc_status' => 'success',
            'order_status' => 'received',
        ];
    }
);
