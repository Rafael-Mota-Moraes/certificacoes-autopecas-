<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Reseller extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'photo',
        'user_id',
        'latitude',
        'longitude',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the address associated with the reseller.
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    /**
     * Get the contacts associated with the reseller.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function getPhotoAttribute($value): string
    {
        if ($value) {
            return Storage::url($value);
        }

        return "/images/car-placeholder.png";
    }
}
