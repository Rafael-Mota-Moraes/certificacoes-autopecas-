<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        "reseller_id",
        "status",
        "amount",
        "payment_expires_at",
        "payment_provider_id",
        "pix_qr_code",
        "pix_emv",
    ];

    protected $casts = [
        'payment_expires_at' => 'datetime',
    ];

    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class);
    }
}
