<?php

namespace App\Services\DataObjects;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;

class Color implements JsonSerializable, Arrayable, Jsonable
{
    private string $name;
    private string $hex;
    /** @var list<int> */
    private array $rgb;

    public function __construct(string $name, string $hex, array $rgb)
    {
        $this->name = $name;
        $this->hex = $hex;
        $this->rgb = $rgb;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function hex(): string
    {
        return $this->hex;
    }

    /** @return list<int> */
    public function rgb(): array
    {
        return $this->rgb;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'hex'  => $this->hex,
            'rgb'  => $this->rgb,
        ];
    }
}
