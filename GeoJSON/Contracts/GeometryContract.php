<?php

namespace GeoJSON\Contracts;

interface GeometryContract
{
    public function toArray();

    /**
     * Returns the coordinates of the Geometry.
     *
     * @return array
     */
    public function getCoordinates(): array;
}
