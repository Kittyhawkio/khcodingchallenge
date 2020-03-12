<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Flight extends Model
{
    use SoftDeletes;

    protected $casts = [
        'flight_time'         => 'datetime',
        'duration_in_seconds' => 'integer',
        'lat'                 => 'float',
        'long'                => 'float',
    ];

    protected $attributes = [
        'notes'               => '',
        'duration_in_seconds' => 0,
    ];

    public function weather(): HasOne
    {
        return $this->hasOne(Weather::class);
    }

    public function airspace(): HasOne
    {
        return $this->hasOne(Airspace::class);
    }
}
