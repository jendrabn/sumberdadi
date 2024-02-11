<?php

use App\Models\Product;
use App\Models\ProductRating;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(ProductRating::class, function (Faker $faker) {
    return [
        'rate' => $faker->numberBetween(3, 5),
        'comment' => $faker->realText(),
        'is_flagged' => $faker->boolean,

        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'product_id' => function () {
            return Product::inRandomOrder()->first()->id;
        },
    ];
});
