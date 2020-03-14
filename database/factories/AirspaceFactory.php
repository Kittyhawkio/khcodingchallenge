<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Airspace;
use Illuminate\Support\Arr;
use Faker\Generator as Faker;
use App\Services\DataObjects\Color;

$factory->define(Airspace::class, function (Faker $faker) {
    return [
        'short_overview' => $faker->word,
        'full_overview' => $faker->words(3, true),
        'color' => new Color($faker->colorName, $faker->hexColor, $faker->rgbColorAsArray),
        'classes' => [Arr::random(['C', '', ''])],
        'airports' => [Arr::random(['AUS', 'SFO', 'JFK', '', ''])],
        'advisories' => [],
    ];
});
