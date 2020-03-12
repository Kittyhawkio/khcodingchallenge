<?php

namespace App\Services\DataObjects;

use JsonSerializable;

class Color implements JsonSerializable
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
        return [
            'name' => $this->name,
            'hex'  => $this->hex,
            'rgb'  => $this->rgb,
        ];
    }
}
