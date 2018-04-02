<?php

use Faker\Generator as Faker;

$factory->define(App\Note::class, function (Faker $faker) {
    return [
        'author_id' => $faker->numberBetween(1, 5),
        'title' => $faker->text(30),
        'body' => $faker->text(200),
    ];
});
