<?php

namespace GeoJSON\Geometry;

use App\GeoJSON\Spec;
use Exception;
use GeoJSON\Contracts\GeometryContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection as LaravelCollection;

class Collection extends LaravelCollection implements GeometryContract, Arrayable
{
    public function toArray()
    {
        return [
            'type'       => Spec::GEOMETRY_COLLECTION,
            'geometries' => $this->items,
        ];
    }

    public function __toString()
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }

    /**
     * Returns the coordinates of the Geometry.
     *
     * @return array
     */
    public function getCoordinates(): array
    {
        throw new Exception('Unable to provide coordinates for a collection.');
    }
}
