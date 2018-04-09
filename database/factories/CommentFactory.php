<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'post_id' => rand(1,30),
        'title' => $faker->sentence(4),
        'comment' =>$faker->sentence,

    ];
});
