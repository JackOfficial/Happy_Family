<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'job_id',
        'country_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'city',
        'level_of_education',
        'field_of_study',
        'years_of_experience',
        'notice_period',
        'desired_salary',
        'currency',
        'linkedin_url',
        'portfolio_url',
        'referral_source',
        'additional_notes',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'desired_salary' => 'decimal:2',
        'years_of_experience' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get the job/vacancy this application is for.
     */
    public function job(): BelongsTo
    {
        // Using job_id from your updated migration
        return $this->belongsTo(Job::class);
    }

    /**
     * Get the country of the applicant.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Polymorphic Relationship: Get all files (CV, IDs, etc.)
     * This replaces the hardcoded 'resume' and 'cover_letter' columns.
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Helper: Get full name for the NGO Admin Dashboard.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}