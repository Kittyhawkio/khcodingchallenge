<?php

namespace App\Jobs;

use App\Flight;
use App\Weather;
use DmitryIvanov\DarkSkyApi\Service as DarkSky;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetFlightWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Flight $flight;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Flight $flight)
    {
        $this->flight = $flight;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(DarkSky $darkSky): void
    {
        $weather = $darkSky->location($this->flight->lat, $this->flight->long)
            ->units('us')
            ->timeMachine($this->flight->flight_time->toISOString())
            ->currently();

        $flightWeather = $this->flight->weather ?? new Weather();
        $flightWeather->temperature = $weather->temperature();
        $flightWeather->weather_blurb = $weather->summary();

        $this->flight->weather()->save($flightWeather);

        Log::info(json_encode([
            'flight_id' => $this->flight->id,
            'latitude' => $this->flight->lat,
            'longitude' => $this->flight->long,
            'temperature' => $weather->temperature(),
            'weather_blurb' => $weather->summary(),
        ]));
    }
}
