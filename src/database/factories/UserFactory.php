<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
    User::class,
    function (Faker $faker) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $token = substr(str_shuffle($permitted_chars), 0, 50);
        if (User::where('token', $token)->exists()) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            // Output: 54esmdr0qf
            $uniquetoken = substr(str_shuffle($permitted_chars), 0, 60);
        } else {
            $uniquetoken = $token;
        }
        return [
            'firstname' => $faker->name,
            'lastname' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'is_admin' => null,
            'phone' => $faker->phoneNumber,
            'token' => $uniquetoken,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token' => Str::random(10),
        ];
    }
);
