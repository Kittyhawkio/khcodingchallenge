<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Weather;
use Faker\Generator as Faker;

$factory->define(Weather::class, function (Faker $faker) {
    return [
        'temperature' => rand(32, 110),
        'weather_blurb' => $faker->sentence,
    ];
});
