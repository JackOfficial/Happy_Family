<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Country extends Model
{
    protected $fillable = ['name', 'iso_code', 'phone_code', 'is_active'];

    /**
     * Ensure is_active is always treated as a boolean.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: One country can have many applications.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Scope a query to only include active countries.
     * Usage: Country::active()->get();
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}