<?php

namespace App;

use App\Casts\AdvisoryArray;
use App\Casts\Color;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Airspace extends Model
{
    protected $casts = [
        'color'      => Color::class,
        'advisories' => AdvisoryArray::class,
        'airports'   => 'array',
        'classes'    => 'array',
    ];

    protected $hidden = ['flight_id', 'created_at'];

    public function flight(): BelongsTo
    {
        return $this->belongsTo(Flight::class);
    }
}
