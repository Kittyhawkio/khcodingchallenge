<?php

namespace App\Casts;

use App\Services\DataObjects\Color as ColorObject;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Color implements CastsAttributes
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

        if (! isset($values['name']) && ! isset($values['hex']) && ! isset($values['rgb'])) {
            return null;
        }

        return new ColorObject($values['name'], $values['hex'], $values['rgb']);
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
