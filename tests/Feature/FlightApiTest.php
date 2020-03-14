<?php

namespace Tests\Feature;

use App\Airspace;
use App\Flight;
use App\Weather;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlightApiTest extends TestCase
{
    use RefreshDatabase;

    private const LATITUDE = 30.1982266;
    private const LONGITUDE = -97.6686707;

    /** @test */
    function it_can_list_flights()
    {
        $flight = factory(Flight::class)->create();
        $weather = factory(Weather::class)->create(['flight_id' => $flight->id]);
        $airspace = factory(Airspace::class)->create(['flight_id' => $flight->id]);

        $this->json('GET', '/flights')
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'latitude' => $flight->lat,
                        'longitude' => $flight->long,
                        'id' => $flight->id,
                        'updated_at' => $flight->updated_at->toISOString(),
                        'created_at' => $flight->created_at->toISOString(),
                        'deleted_at' => null,
                        'duration_in_seconds' => $flight->duration_in_seconds,
                        'notes' => $flight->notes,
                        'weather' => $weather->toArray(),
                        'airspace' => $airspace->toArray(),
                    ],
                ],
            ])->assertJsonStructure([
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'path',
                    'per_page',
                    'to',
                    'total',
                ],
            ]);
    }

    /** @test */
    function it_can_create_a_new_flight()
    {
        $this->json('POST', '/flights', [
            'latitude' => self::LATITUDE,
            'longitude' => self::LONGITUDE,
            'date' => now()->toISOString(),
            'notes' => 'Test flight'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'latitude' => self::LATITUDE,
                    'longitude' => self::LONGITUDE,
                    'notes' => 'Test flight',
                    'airspace' => [
                        'short_overview' => 'Authorization',
                        'full_overview' => 'Authorization Required airspace',
                        'airports' => [
                            'KAUS',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    function it_has_validation_for_creation(float $lat, float $long, string $date)
    {
        $this->json('POST', '/flights', [
            'latitude' => $lat,
            'longitude' => $long,
            'date' => $date,
        ])->assertStatus(422);
    }

    /** @test */
    function it_has_validation_for_creation_with_required()
    {
        $this->json('POST', '/flights', [])->assertStatus(422);
    }

    /** @test */
    function it_can_edit_a_flight()
    {
        $flight = factory(Flight::class)->create();
        factory(Weather::class)->create(['flight_id' => $flight->id]);
        factory(Airspace::class)->create(['flight_id' => $flight->id]);

        $this->json('PATCH', "/flights/{$flight->id}", [
            'latitude' => self::LATITUDE,
            'longitude' => self::LONGITUDE,
            'notes' => 'Test flight'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $flight->id,
                    'latitude' => self::LATITUDE,
                    'longitude' => self::LONGITUDE,
                    'notes' => 'Test flight',
                    'airspace' => [
                        'short_overview' => 'Authorization',
                        'full_overview' => 'Authorization Required airspace',
                        'airports' => [
                            'KAUS',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    function it_has_validation_for_update(float $lat, float $long, string $date)
    {
        $flight = factory(Flight::class)->create();
        factory(Weather::class)->create(['flight_id' => $flight->id]);
        factory(Airspace::class)->create(['flight_id' => $flight->id]);

        $this->json('PUT', "/flights/{$flight->id}", [
            'latitude' => $lat,
            'longitude' => $long,
            'date' => $date,
        ])->assertStatus(422);
    }

    /** @test */
    function it_has_no_required_validation_for_update()
    {
        $flight = factory(Flight::class)->create();
        factory(Weather::class)->create(['flight_id' => $flight->id]);
        factory(Airspace::class)->create(['flight_id' => $flight->id]);

        $this->json('PUT', "/flights/{$flight->id}", [])->assertStatus(200);
    }

    public function validationProvider(): array
    {
        return [
            'invalid Latitude' => [180, 100, now()->toISOString()],
            'invalid Longitude' => [65, 300, now()->toISOString()],
            'invlaid Date' => [65, 65, 'blah'],
        ];
    }
}
