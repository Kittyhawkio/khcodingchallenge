<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlightRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'latitude' => [
                'numeric',
                'min:-90',
                'max:90',
            ],
            'longitude' => [
                'numeric',
                'min:-180',
                'max:180',
            ],
            'date' => [
                'date',
                'after:1990',
            ],
            'notes' => [
                'string',
                'max:250',
            ],
            'duration_of_flight' => [
                'integer',
                'min:0',
            ],
        ];
    }
}
