<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Flight;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Flight::class, function (Faker $faker) {
    return [
        'flight_time' => $faker->dateTimeBetween('now', '+6 weeks'),
        'lat' => $faker->latitude,
        'long' => $faker->longitude,
        'duration_in_seconds' => $faker->numberBetween(100,999),
        'notes' => $faker->paragraphs(5, true),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
