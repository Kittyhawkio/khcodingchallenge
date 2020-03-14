<?php

namespace GeoJSON\Geometry;

use GeoJSON\Contracts\GeometryContract;

/**
 * A factory for generating different Geometry types for GeoJSON.
 */
final class Factory
{
    /** @var array<float> */
    private array $coordinates = [];

    /** @var array<\GeoJSON\Contracts\GeometryContract> */
    private array $geometries = [];

    private string $type = '';

    /**
     * This function doesn't do anything, except for allow for an initial static
     *  call.
     *
     * @return static
     */
    public static function prep(): self
    {
        return new static;
    }

    /**
     * Set the coordinates of the Geometry.
     *
     * @param array<float> $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Set the coordinates of the Geometry.
     *
     * @param array<float> $coordinates
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Adds a Geometry for generating a GeometryCollection.
     *
     * @param GeometryContract $geometry
     * @return self
     */
    public function addGeometry(GeometryContract $geometry): self
    {
        $this->geometries[] = $geometry;

        return $this;
    }

    /**
     * The final call in the chain, it will generate the Geometry object.
     * **Note:** Currently only {@see \GeoJSON\Geometry\Point} and
     *  {@see \GeoJSON\Geometry\GeometryCollection} are supported.
     *
     * @return \GeoJSON\Contracts\GeometryContract
     */
    public function get(): GeometryContract
    {
        if (! empty($this->geometries)) {
            return new Collection($this->geometries);
        }

        return new Point(...$this->coordinates);
    }
}
