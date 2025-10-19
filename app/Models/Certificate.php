<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        "reseller_id",
        "status",
        "payment_id",
        "qr_code_data",
        "amount",
        "payment_expires_at",
    ];


    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class);
    }
}
