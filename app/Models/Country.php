<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ['name', 'iso_code', 'phone_code', 'is_active'];

    /**
     * Relationship: One country can have many applications.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}