<?php

use App\Models\Community;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Community::class, function (Faker $faker) {
    return [
        'is_active' => $faker->boolean(90),
        'name' => $faker->firstName,
        'logo' => 'https://picsum.photos/seed/'. $faker->word .'/300/300',
        'description' => $faker->text,
        'founded_at' => $faker->dateTimeThisDecade,
        'user_id' => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});
