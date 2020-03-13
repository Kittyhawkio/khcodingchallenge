<?php

namespace Tests\Unit;

use GeoJSON\Geometry\Collection;
use GeoJSON\Geometry\Factory;
use GeoJSON\Geometry\Point;
use PHPUnit\Framework\TestCase;

class GeoJSONTest extends TestCase
{

    /** @test */
    public function factory_returns_a_point_object()
    {
        $geo = Factory::prep()
            ->setCoordinates([1.2, 3.4]) // set in lat/long
            ->get();
        $this->assertInstanceOf(Point::class, $geo);
        [$long, $lat] = $geo->getCoordinates(); // retrieve in long/lat
        $this->assertSame(3.4, $long);
        $this->assertSame(1.2, $lat);
    }

    /** @test */
    public function factory_returns_collection_when_provided_geometries()
    {
        $point = Factory::prep()
            ->setCoordinates([1.2, 3.4])
            ->get();
        $collection = Factory::prep()
            ->addGeometry($point)
            ->get();

        $this->assertInstanceOf(Collection::class, $collection);
    }
}
