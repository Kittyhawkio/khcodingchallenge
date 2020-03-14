<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Flight;
use Faker\Generator as Faker;

$factory->define(Flight::class, function (Faker $faker) {
    $rand = fn(float $min, float $max): float => round(($min + (mt_rand() / mt_getrandmax()) * abs($max-$min)), 6);

    return [
        'flight_time' => now(),
        'lat' => $rand(-90, 90),
        'long' => $rand(-90, 90),
        'duration_in_seconds' => mt_rand(0, 900),
        'notes' => $faker->sentence,
    ];
});
