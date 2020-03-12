<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weather extends Model
{
    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
