<?php

use App\Models\Community;
use App\Models\CommunityEvent;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(CommunityEvent::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'banner' => 'https://picsum.photos/seed/'. $faker->word .'/300/300',
        'description' => $faker->text,
        'location' => $faker->streetAddress,
        'max_attendees' => $faker->randomNumber(),
        'started_at' => $faker->dateTimeThisMonth->format('Y-m-d\TH:i'),
        'ended_at' => $faker->dateTimeThisMonth->format('Y-m-d\TH:i'),

        'community_id' => function () {
            return Community::inRandomOrder()->first()->id;
        },
    ];
});
