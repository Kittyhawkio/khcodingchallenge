<?php

namespace App\Services\DataObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class Advisory implements JsonSerializable, Arrayable, Jsonable
{
    private Color $color;
    private string $type;
    private string $name;
    private string $description;
    /** @var array<array{type:string,key:string,value:string}> */
    private array $details;
    /** @var array{value:float,unit:string,lat:float,long:float} */
    private array $distance;
    /** @var array<string,mixed> */
    private array $properties;

    public function __construct(array $data)
    {
        $this->color = new Color($data['color']['name'], $data['color']['hex'], $data['color']['rgb']);
        $this->type = $data['type'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->details = $data['details'] ?? [];
        $this->distance = $data['distance'] ?? [];
        $this->properties = $data['properties'] ?? [];
    }

    public function color(): Color
    {
        return $this->color;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    /** @return array<array{type:string,key:string,value:string}> */
    public function details(): array
    {
        return $this->details;
    }

    /** @var array{value:float,unit:string,lat:float,long:float} */
    public function distance(): array
    {
        return $this->distance;
    }

    /** @var array<string,mixed> */
    public function properties(): array
    {
        return $this->properties;
    }

    public function toArray()
    {
        return [
            'color'       => $this->color,
            'type'        => $this->type,
            'name'        => $this->name,
            'description' => $this->description,
            'details'     => $this->details,
            'distance'    => $this->distance,
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
