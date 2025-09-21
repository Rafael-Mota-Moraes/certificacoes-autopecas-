<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Review extends Model
{

    use HasFactory;

    protected $fillable = [
        "reseller_id",
        "user_id",
        "rating",
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class);
    }


    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class);
    }
}
