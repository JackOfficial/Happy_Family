<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, MorphMany, MorphOne, BelongsToMany};

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'title',
        'slug',
        'summary',
        'description',
        'goal',
        'beneficiaries',
        'budget',
        'start_date',
        'end_date',
        'duration', // Added to match UI
        'progress',
        'status',
    ];

    /**
     * Laravel 12 style Attribute Casting
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date'   => 'datetime',
            'budget'     => 'decimal:2',
            'progress'   => 'integer',
        ];
    }

    /**
     * Boot method to handle cascading soft deletes
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($project) {
            if ($project->isForceDeleting()) {
                // Force delete children
                $project->project_photos()->forceDelete();
                $project->documents()->forceDelete();
                $project->donations()->forceDelete();
            } else {
                // To ensure the "deleting" event fires for each child (triggers file cleanup logic)
                $project->project_photos->each->delete();
                $project->documents->each->delete();
                $project->donations->each->delete();
            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /* RELATIONSHIPS                                                              */
    /* -------------------------------------------------------------------------- */

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
 * The user who originally uploaded/created the project.
 */
public function creator(): BelongsTo
{
    return $this->belongsTo(User::class, 'created_by');
}

/**
 * The user who last renamed or updated the project.
 */
public function editor(): BelongsTo
{
    return $this->belongsTo(User::class, 'updated_by');
}

    /**
     * Project now belongs to many Causes (Mission Categories)
     */
    public function causes(): BelongsToMany
    {
        return $this->belongsToMany(Cause::class, 'cause_project');
    }

    /**
     * Get all project gallery photos.
     */
    public function project_photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    /**
     * Get the main featured photo.
     */
    public function featured_photo(): MorphOne
    {
        return $this->morphOne(Photo::class, 'imageable')->where('is_featured', true);
    }

    /**
     * Get all project related documents.
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /* -------------------------------------------------------------------------- */
    /* ACCESSORS                                                                  */
    /* -------------------------------------------------------------------------- */

    /**
     * Get the featured image URL or a default placeholder.
     */
    public function getFeaturedImageUrlAttribute(): string
    {
        // Try featured photo first, then fallback to first photo, then placeholder
        $photo = $this->featured_photo ?? $this->project_photos->first();

        return $photo 
            ? asset('storage/' . $photo->file_path) 
            : asset('images/placeholder-project.jpg');
    }

    /* -------------------------------------------------------------------------- */
    /* SCOPES                                                                     */
    /* -------------------------------------------------------------------------- */

    public function scopeActive($query)
    {
        return $query->where('status', 'Ongoing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'Completed');
    }
}