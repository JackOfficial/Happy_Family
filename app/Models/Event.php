<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany; // Added this import
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes;

  protected $fillable = [
    'organization_id', 'title', 'slug', 'description', 
    'location', 'date', 'time', 'link', 'status',
    'created_by', 'updated_by' // Added user tracking
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
        static::deleting(function ($event) {
            $event->event_photos()->delete();
            $event->documents()->delete(); // Also cleanup documents
        });
    }

    public function creator() {
    return $this->belongsTo(User::class, 'created_by');
}

    /**
     * Generate a unique slug based on the title.
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

    public function organization() 
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get all event photos.
     */
    public function event_photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    /**
     * Get all event related documents (PDFs, Reports, etc).
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Use 'slug' instead of 'id' for Route Model Binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}