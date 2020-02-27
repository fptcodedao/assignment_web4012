<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Categories;
use Faker\Generator as Faker;

$factory->define(Categories::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'parent_id' => rand(1, 10),
        'thumb_img' => $faker->imageUrl()
    ];
});
