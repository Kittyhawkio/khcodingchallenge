<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Flight;
use Faker\Generator as Faker;

$factory->define(Flight::class, function (Faker $faker) {
    return [
        'flight_time' => now(),
        'lat' => rand(-90, 90),
        'long' => rand(-90, 90),
        'duration_in_seconds' => rand(0, 900),
        'notes' => $faker->sentence,
    ];
});
