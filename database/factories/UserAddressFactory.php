<?php

use App\Models\User;
use App\Models\UserAddress;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(UserAddress::class, function (Faker $faker) {
    $city = \App\Models\City::inRandomOrder()->first();
    return [
        'name' => $faker->name,
        'address' => $faker->address,
        'zipcode' => $faker->postcode,
        'phone' => $faker->phoneNumber,
        'created_at' => $faker->word,
        'updated_at' => $faker->word,

        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        },
        'city_id' => function () use($city) {
            return $city->id;
        },
        'province_id' => function () use ($city) {
            return $city->province->id;
        }
    ];
});
