<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FlightTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testFlightCreate()
    {
        $response = $this->postJson('/api/flights', [
            'flight_time' => (new \DateTime('+2 weeks'))->format('c'),
            'lat' => $this->faker()->latitude,
            'long' => $this->faker()->longitude,
            'duration_in_seconds' => $this->faker()->numberBetween(100,999),
            'notes' => 'These are some test notes',
        ]);

        $response->dump();

        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => [
                    'notes' => 'These are some test notes'
                ]
            ])
        ;
    }
}
