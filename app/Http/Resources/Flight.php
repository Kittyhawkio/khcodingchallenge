<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Flight extends JsonResource
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
            'id' => $this->id,
            'flight_time' => (string) $this->flight_time,
            'lat' => $this->lat,
            'long' => $this->long,
            'duration_in_seconds' => $this->duration_in_seconds,
            'notes' => $this->notes,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            // Flight Info Properties
            'weather_summary' => $this->weather_summary,
            'temperature' => $this->temperature,
            'airspace_color' => $this->airspace_color,
            'airspace_summary' => $this->airspace_summary
        ];
    }
}
