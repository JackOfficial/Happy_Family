<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * Based on your controller: name, slug, description, and icon are required.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
    ];

    /**
     * Get the jobs associated with the category.
     */
    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Route Key Name
     * This allows Laravel to use the 'slug' for URL generation 
     * instead of the ID automatically.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}