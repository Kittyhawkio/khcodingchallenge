<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{

    protected $fillable = ['flight_time', 'lat', 'long', 'duration_in_seconds', 'notes'];

    protected $guarded = [
        'weather_summary',
        'temperature',
        'airspace_color',
        'airspace_summary',
    ];

    protected $dates = ['flight_time', 'created_at', 'updated_at'];

    protected $dateFormat = 'c';

    protected $casts = [
        'lat' => 'decimal:6',
        'long' => 'decimal:6',
    ];
}
