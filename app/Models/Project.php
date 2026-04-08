<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany, MorphMany, MorphOne};

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'cause_id',
        'title',
        'slug',
        'summary',
        'description',
        'goal',
        'beneficiaries',
        'budget',
        'start_date',
        'end_date',
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
            // To ensure the "deleting" event fires for each child 
            // (important if they have their own file cleanup logic), 
            // it is better to do this:
            $project->project_photos->each->delete();
            $project->documents->each->delete();
            $project->donations->each->delete();
        }
    });
}

    /* -------------------------------------------------------------------------- */
    /* RELATIONSHIPS                               */
    /* -------------------------------------------------------------------------- */

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class);
    }

    /**
     * Get all project gallery photos.
     */
    public function project_photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    /**
     * Get the main featured photo (useful for thumbnails).
     */
    public function project_photo(): MorphOne
    {
       return $this->morphOne(Photo::class, 'imageable')->where('is_featured', true);
    }

    /**
     * Get all project related documents (PDFs, Reports, etc).
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class);
    }

    /**
 * Get the featured image URL or a default placeholder.
 */
public function getFeaturedImageUrlAttribute(): string
{
    return $this->project_photo 
        ? asset('storage/' . $this->project_photo->file_path) 
        : asset('images/placeholder-project.jpg');
}

    /* -------------------------------------------------------------------------- */
    /* SCOPES                                   */
    /* -------------------------------------------------------------------------- */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}