<?php

namespace App\Jobs;

use App\Flight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Naughtonium\LaravelDarkSky\Facades\DarkSky;
use Illuminate\Support\Facades\Http;

class FlightEnvironmentStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $flight;

    /**
     * Create a new job instance.
     *
     * @param Flight $flight
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
    public function handle()
    {
        Log::debug(sprintf('Starting Flight Info Request for flight: %d.', $this->flight->id));
        try {
            // Fetch weather info summary for place and time
            $report = DarkSky::location($this->flight->lat, $this->flight->long)
                ->atTime($this->flight->flight_time->getTimestamp())
                ->currently()
            ;

            $this->flight->setAttribute('weather_summary', $report->summary ?? null);
            $this->flight->setAttribute('temperature', $report->temperature ?? null);

            // Fetch KW Airspace advisory info
            $response = Http::post('https://app.kittyhawk.io/api/atlas/advisories', [
                'geometry' => [
                    'format' => 'geojson',
                    'data' => json_encode([
                        'type' => 'Point',
                        'coordinates' => [
                            (float) $this->flight->long,
                            (float) $this->flight->lat
                        ],
                    ], JSON_THROW_ON_ERROR, 512),
                ],
            ]);

            $res = $response->json();

            $color = $res['data']['color']['name'] ?? null;
            $overview = $res['data']['overview']['short'] ?? null;

            $this->flight->setAttribute('airspace_color', $color);
            $this->flight->setAttribute('airspace_summary', $overview);
            $this->flight->setAttribute('warning', $color !== 'green');

            $this->flight->save();

            Log::debug(sprintf('Flight Info Successfully fetched for flight: %d.', $this->flight->id));
        } catch (\Exception $e) {
            // @TODO: test exception handling
            Log::debug(sprintf('Flight Info Failed to fetch for flight: %d with message: %s.', $this->flight->id, $e->getMessage()));
            throw $e;
        }
    }
}
