<?php

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Order::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement(['Pending', 'Shipped', 'Completed', 'Cancelled']),
        'description' => $faker->realText(),
        'shipping_cost' => $faker->numberBetween(10000,100000),

        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'store_id' => function () {
            return Store::inRandomOrder()->first()->id;
        }
    ];
});
