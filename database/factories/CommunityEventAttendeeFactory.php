<?php

use App\Models\CommunityEvent;
use App\Models\CommunityEventAttendee;
use App\Models\CommunityMember;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(CommunityEventAttendee::class, function (Faker $faker) {
    return [
        'is_absent' => $faker->boolean,
        'description' => $faker->realText(),

        'event_id' => function () {
            return CommunityEvent::inRandomOrder()->first()->id;
        },
        'community_member_id' => function () {
            return CommunityMember::inRandomOrder()->first()->id;
        },
    ];
});
