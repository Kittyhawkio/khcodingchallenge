<?php

namespace App\Casts;

use App\Services\DataObjects\Advisory as AdvisoryObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AdvisoryArray implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        $values = json_decode($value, true);
        $advisories = [];
        foreach ($values as $advisory) {
            $advisories[] = new AdvisoryObject($advisory);
        }

        return $advisories;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }
}
