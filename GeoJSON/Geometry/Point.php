<?php

namespace GeoJSON\Geometry;

use GeoJSON\Spec;
use GeoJSON\Contracts\GeometryContract;
use Illuminate\Contracts\Support\Arrayable;

class Point implements GeometryContract, Arrayable
{
    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Returns the coordinates of the Geometry.
     *
     * @return array
     */
    public function getCoordinates(): array
    {
        return [$this->longitude, $this->latitude];
    }

    /** @return array{type:string,geometry:array<float>} */
    public function toArray()
    {
        return [
            'type'        => Spec::POINT,
            'coordinates' => $this->getCoordinates(),
        ];
    }

    /** @return string */
    public function __toString()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
