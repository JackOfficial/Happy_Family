<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Cause extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status' // Active, Completed, Pending, etc.
    ];
    
    // Relationship for the full gallery
    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    // Relationship for the single cover image
    public function mainPhoto()
    {
        return $this->morphOne(Photo::class, 'imageable')->latestOfMany();
    }
    
    public function stories()
    {
        return $this->hasMany(Story::class);
    }
    
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * UI/UX Accessor: Ensures a card always has an image.
     * Usage: <img src="{{ $cause->thumbnail_url }}">
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->mainPhoto && $this->mainPhoto->file_path) {
            return asset('storage/' . $this->mainPhoto->file_path);
        }
        
        // Fallback to a brand-colored placeholder if no image exists
        return asset('images/placeholders/cause-default.jpg');
    }

    /**
     * SEO Helper: For clean URLs in 2026
     */
    public function getRouteKeyName()
    {
        return 'slug'; // Requires adding a 'slug' column to your migration
    }
}