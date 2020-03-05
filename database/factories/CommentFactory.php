<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => \App\Models\User::inRandomOrder()->first()->id,
        'post_id' => \App\Models\Post::inRandomOrder()->first()->id,
        'content' => $faker->text
    ];
});
