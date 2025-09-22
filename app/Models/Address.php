<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Address extends Model
{
    use HasFactory;


    protected $fillable = [
        'street',
        'number',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude'
    ];

    /**
     * Get the reseller that owns the address.
     */
    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class);
    }
}
