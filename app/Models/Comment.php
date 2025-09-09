<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Comment extends Model
{
    protected $fillable = ['comment'];

    public function reviews(): BelongsToMany
    {
        return $this->belongsToMany(Review::class);
    }
}
