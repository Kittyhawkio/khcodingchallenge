<?php

namespace App\Services\DataObjects;

use GeoJSON\Contracts\GeometryContract;
use GeoJSON\Geometry\Factory;

class KittyhawkResponse
{
    private string $status;
    private Color $color;
    private array $errors;
    private GeometryContract $geometry;
    private string $shortOverview;
    private string $fullOverview;
    /** @var list<Advisory> */
    private array $advisories;
    /** @var list<string> */
    private array $airports;
    /** @var list<string> */
    private array $classes;

    public function __construct(array $response)
    {
        if (isset($response['errors'])) {
            $this->error($response['errors']);
        }

        $this->build($response);
    }

    private function error(array $error): self
    {
        $this->errors = $error;
        $this->status = 'error';
        $this->color = new Color('red', '#ff0000', [256,0,0]);
        $this->geometry = Factory::prep()->setCoordinates([0,0])->get();
        $this->shortOverview = 'error';
        $this->fullOverview = 'error';
        $this->advisories = [];
        $this->airports = [];
        $this->classes = [];

        return $this;
    }

    private function build(array $response): self
    {
        $this->status = $response['status'];
        $this->errors = [];
        $data = $response['data'];
        $this->color = new Color(
            $data['color']['name'],
            $data['color']['hex'],
            $data['color']['rgb']
        );
        $geo = json_decode($data['geometry']['data']);
        $this->geometry = Factory::prep()
            ->setType($geo->type)
            ->setCoordinates($geo->coordinates)
            ->get();
        $this->shortOverview = $data['overview']['short'];
        $this->fullOverview = $data['overview']['full'];
        foreach ($data['advisories'] as $advisory) {
            $this->advisories[] = new Advisory($advisory);
        }
        $this->airports = $data['airports'];
        $this->classes = $data['classes'];

        return $this;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function color(): Color
    {
        return $this->color;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function geometry(): GeometryContract
    {
        return $this->geometry;
    }

    public function shortOverview(): string
    {
        return $this->shortOverview;
    }

    public function fullOverview(): string
    {
        return $this->fullOverview;
    }

    /** @return list<Advisory> */
    public function advisories(): array
    {
        return $this->advisories;
    }

    /** @return list<string> */
    public function airports(): array
    {
        return $this->airports;
    }

    /** @return list<string> */
    public function classes(): array
    {
        return $this->classes;
    }
}
