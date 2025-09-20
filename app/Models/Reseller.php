<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reseller extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "resellers";
    protected $fillable = [
        'name',
        'cnpj',
        'photo',
    ];

    /**
     * Get the address associated with the reseller.
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * Get the contacts associated with the reseller.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }
}
