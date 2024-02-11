<?php

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityRole;
use App\Models\User;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(CommunityMember::class, function (Faker $faker) {
    $community = Community::inRandomOrder()->first();
    return [
        'user_id' => function () use($community) {
            return User::inRandomOrder()->first()->id;
        },
        'community_id' => function () use ($community) {
            return $community->id;
        },
        'community_role_id' => function () {
            return CommunityRole::inRandomOrder()->first()->id;
        },
        'joined_at' => $faker->dateTimeThisYear,
    ];
});
