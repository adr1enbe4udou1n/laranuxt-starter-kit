<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $attributes = [
        'title'       => ucfirst($faker->words(5, true)),
        'type'        => $faker->randomElement(['post', 'page']),
        'status'      => $faker->randomElement(['published', 'draft']),
        'is_pinned'   => $faker->boolean(25),
        'body'        => $faker->paragraphs(9, true),
    ];

    if ($faker->boolean) {
        $attributes['summary'] = $faker->paragraph;
    }

    if ($faker->boolean(75)) {
        $attributes['publication_date'] = $faker->dateTimeBetween('-6 days');
    }

    return $attributes;
});

$factory->state(Post::class, 'post', [
    'type' => 'post',
]);

$factory->state(Post::class, 'page', [
    'type' => 'page',
]);

$factory->state(Post::class, 'published', [
    'status' => 'published',
]);
