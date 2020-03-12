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
            ->setCoordinates([1.2, 3.4])
            ->get();
        $this->assertInstanceOf(Point::class, $geo);
        [$x, $y] = $geo->getCoordinates();
        $this->assertSame(1.2, $x);
        $this->assertSame(3.4, $y);
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
