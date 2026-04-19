<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory, SoftDeletes;
    
  protected $fillable = [
    'title', 'slug', 'organization_id', 'user_id', 'cause_id', 
    'summary', 'content', 'status', 'created_by', 'updated_by' // Added user tracking
];

    /**
     * Use Slug for Route Model Binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function creator() {
    return $this->belongsTo(User::class, 'created_by');
}

public function documents() {
    return $this->morphMany(Document::class, 'documentable'); // Fixed to Polymorphic
}
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($story) {
            // This handles the DB records; physical file deletion 
            // is already handled in your Controller's destroy method.
            $story->photos()->delete();
        });
    }
    
    /**
     * Relationships
     */
    public function cause()
    {
        return $this->belongsTo(Cause::class, 'cause_id');
    }

    public function organization() 
    {
        return $this->belongsTo(Organization::class);
    }

    // Many photos (Gallery)
    public function photos() 
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
    
    // Single featured photo
    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable')->latestOfMany();
    }

    public function user() 
    {
        return $this->belongsTo(User::class); 
    }
}