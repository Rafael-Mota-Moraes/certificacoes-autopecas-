<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status',
        'validate',
        'created_at',
        'city',
        'signature',
        'text',
        'is_active',
        'is_approved'
    ];

    /**
     * Get the address associated with the reseller.
     */
    public function status(): String
    {
        return $this->status;
    }
    public function validate(): String
    {
        return $this->validate;
    }public function created_at(): String
    {
        return $this->created_at;
    }public function city(): String
    {
        return $this->city;
    }public function signature(): String
    {
        return $this->signature;
    }public function text(): String
    {
        return $this->text;
    }
    public function is_active(): String
    {
        return $this->is_active;
    }
    public function is_approved(): String
    {
        return $this->is_approved;
    }
}
