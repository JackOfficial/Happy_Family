<?php

namespace App\Http\Controllers\Admin; // Ensure this is App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, MorphMany, MorphOne};

class Story extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'title', 'slug', 'organization_id', 'user_id', 'cause_id', 
        'summary', 'content', 'status', 'created_by', 'updated_by'
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted()
    {
        // 1. Automatically generate slug on creating/updating
        static::saving(function ($story) {
            if (empty($story->slug) || $story->isDirty('title')) {
                $story->slug = Str::slug($story->title);
            }
        });

        // 2. Handle cleanup
        static::deleting(function ($story) {
            // Only delete associated records permanently if it's a Force Delete
            // Otherwise, keep them in case the story is restored.
            if ($story->isForceDeleting()) {
                $story->photos()->delete();
                $story->documents()->delete();
            }
        });
    }

    /**
     * Relationships
     */
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }

    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    // Polymorphic Photos
    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
    
    // Helper for Featured Image
    public function featuredPhoto(): MorphOne
    {
        return $this->morphOne(Photo::class, 'imageable')->oldestOfMany();
    }

// Relationship for the cover image of a story
public function mainPhoto()
{
    return $this->morphOne(Photo::class, 'imageable')->latestOfMany();
}

    // Polymorphic Documents
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}