<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{

    protected $fillable = ['flight_time', 'lat', 'long', 'duration_in_seconds', 'notes'];

}
