<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Job extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'job_category_id',
        'description',
        'requirements',
        'benefits',
        'location',
        'type',
        'is_active',
        'deadline',
    ];

    /**
     * The attributes that should be cast.
     * Ensure deadline is treated as a Carbon instance.
     */
    protected $casts = [
        'deadline' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the job.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    /**
     * Get all applications for this job.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Link to an optional Job Description PDF or document.
     */
    public function jobDescription(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachable')
                    ->where('file_type', 'jd');
    }

    /**
     * Scope to show only open positions on the frontend.
     * Filters by active status and non-expired deadlines.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function($q) {
                         $q->whereNull('deadline')
                           ->orWhere('deadline', '>=', now());
                     });
    }

    /**
     * Use slug instead of ID for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}