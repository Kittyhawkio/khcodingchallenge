<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'flight_time'         => $this->flight_time->toISOString(),
            'latitude'            => $this->lat,
            'longitude'           => $this->long,
            'duration_in_seconds' => $this->duration_in_seconds,
            'notes'               => $this->notes,
            'created_at'          => $this->created_at->toISOString(),
            'updated_at'          => $this->updated_at->toISOString(),
            'deleted_at'          => optional($this->deleted_at)->toISOString(),
            'weather'             => $this->weather->toArray(),
            'airspace'            => $this->airspace->toArray(),
        ];
    }
}
