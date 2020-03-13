<?php

namespace App\Jobs;

use App\Airspace;
use App\Flight;
use Illuminate\Bus\Queueable;
use App\Services\KittyhawkAPI;
use GeoJSON\Geometry\Factory;
use GeoJSON\Spec;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetFlightAdvisories implements ShouldQueue
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
    public function handle(KittyhawkAPI $api): void
    {
        $geometry = Factory::prep()
            ->setCoordinates([$this->flight->lat, $this->flight->long])
            ->setType(Spec::POINT)
            ->get();

        $response = $api->setGeometry($geometry)->query();

        $airspace = $this->flight->airspace ?? new Airspace();
        $airspace->short_overview = $response->shortOverview();
        $airspace->full_overview = $response->fullOverview();
        $airspace->color = $response->color();
        $airspace->advisories = $response->advisories();
        $airspace->airports = $response->airports();
        $airspace->classes = $response->classes();

        $this->flight->airspace()->save($airspace);
    }
}
