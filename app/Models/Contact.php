<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact';

    protected $fillable = [
        'reseller_id',
        'phone',
        'email',
    ];

    /**
     * Get the reseller that owns the contact.
     */
    public function reseller(): BelongsTo
    {
        return $this->belongsTo(Reseller::class);
    }
}
