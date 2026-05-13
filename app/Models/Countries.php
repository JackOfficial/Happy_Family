<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Required for the CountrySeeder to work!
     */
    protected $fillable = [
        'name',
        'iso_code',
        'phone_code',
        'is_active',
    ];

    /**
     * Relationship: A country can have many job applications.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}