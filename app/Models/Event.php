<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id', 
        'cause_id', // Added from migration
        'title', 
        'slug', 
        'description', 
        'location', 
        'date', 
        'time', 
        'link', 
        'status',
        'created_by', 
        'updated_by'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        // Automatically generate a unique slug on creation
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = static::generateUniqueSlug($event->title);
            }
        });

        // Cleanup related assets on deletion
        // Note: With SoftDeletes, these will only be "hidden" unless force-deleted.
        static::deleting(function ($event) {
            if ($event->isForceDeleting()) {
                $event->photos()->delete();
                $event->documents()->delete();
            }
        });
    }

    /**
     * Relationships
     */

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class);
    }

    public function creator(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo 
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Polymorphic Relationships
     * Using 'imageable' and 'documentable' to match your Photo/Document morphs
     */

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    // Helper for a single featured photo
    public function featuredPhoto()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('is_featured', true);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Logic Helpers
     */

    private static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}