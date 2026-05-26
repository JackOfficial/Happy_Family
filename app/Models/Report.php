<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'reportable_id',
        'reportable_type',
        'report_date',
        'tasks_completed',
        'upcoming_tasks',
        'challenges',
        'pdf_file',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'report_date' => 'date',
    ];

    /**
     * Get the parent reportable model (Department, Project, etc.).
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who authored the report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}