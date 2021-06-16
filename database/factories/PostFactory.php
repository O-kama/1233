<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Beseda\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->realText(rand(10, 40));
    $created = $faker->dateTimeBetween('-30 days', '1 days');

    return [
        'title' => $title,
        'author_id' => rand(1, 4),
        'desc' => $faker->realText(rand(100, 500)),
        'created_at' => $created,
        'updated_at' => $created,
    ];
});
