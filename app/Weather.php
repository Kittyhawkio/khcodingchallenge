<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weather extends Model
{
    protected $hidden = ['flight_id', 'created_at'];

    protected $casts = ['temperature' => 'int'];

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
