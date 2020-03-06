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
        'flight_info_hash',
    ];

    protected $dates = ['flight_time', 'created_at', 'updated_at'];

    protected $dateFormat = 'c';

    protected $casts = [
        'lat' => 'decimal:6',
        'long' => 'decimal:6',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($instance){
            $instance->setFlightEnvironmentInfoHash();
        });

        static::updating(function ($instance){
            $instance->setFlightEnvironmentInfoHash();
        });
    }

    /**
     * Create a hash of lat/lng/flight_time attributes.
     * We can check if this property is dirty on update to trigger a new job
     */
    public function setFlightEnvironmentInfoHash()
    {
        $properties = $this->only(['lat', 'long', 'flight_time']);
        if (count($properties) === 3) {
            $this->setAttribute('flight_info_hash', md5(
                ($properties['lat'] ?? 0) .
                ($properties['long'] ?? 0) .
                ($properties['flight_time']->format('U'))
            ));
        } else {
            $this->setAttribute('flight_info_hash', null);
        }

        // Ensure we sync changes to register hash as dirty, if changed
        $this->syncChanges();
    }
}
