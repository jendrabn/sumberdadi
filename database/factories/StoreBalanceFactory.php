<?php

use App\Models\Store;
use App\Models\StoreBalance;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(StoreBalance::class, function (Faker $faker) {
    return [
        'type' => $faker->boolean(90),
        'amount' => $faker->randomElement([-$faker->randomNumber($faker->numberBetween(5, 6)), $faker->randomNumber($faker->numberBetween(5, 6))]),
        'description' => $faker->randomElement([null, $faker->text(50)]),

        'store_id' => function () {
            return Store::inRandomOrder()->first()->id;
        },
    ];
});
