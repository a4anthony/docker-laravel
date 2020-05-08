<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MelaMart\Entities\Category;
use App\MelaMart\Entities\SubCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(
    Category::class,
    function (Faker $faker) {
        $mainCategory = $faker->word;

        return [
            'name' => $faker->word,
            'slug' =>  Str::slug($mainCategory, '-')
        ];
    }
);


$factory->define(
    SubCategory::class,
    function (Faker $faker) {
        $subCategory = $faker->word;

        return [
            'name' => $faker->word,
            'slug' =>  Str::slug($subCategory, '-')

        ];
    }
);
