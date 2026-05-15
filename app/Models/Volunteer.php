<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Carbon\Carbon;

class Volunteer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'country_id',
        'name',
        'dob',
        'email',
        'phone',
        'occupation',
        'skills',
        'reason',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'dob' => 'date',
        'status' => 'string',
    ];

    /**
     * Relationship: A volunteer belongs to a country.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Relationship: A volunteer may be linked to a registered User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Polymorphic address.
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Accessor: Calculate age from DOB.
     * Usage: $volunteer->age
     */
    public function getAgeAttribute(): ?int
    {
        return $this->dob ? $this->dob->age : null;
    }

    /**
     * Scope: Filter by status.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}