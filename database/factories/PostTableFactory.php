<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->text(200),
        'thumb_img' => $faker->imageUrl(),
        'admin_id' => \App\Models\Admin::inRandomOrder()->first()->id,
        'view' => rand(1, 100),
        'status' => 1
    ];
});
