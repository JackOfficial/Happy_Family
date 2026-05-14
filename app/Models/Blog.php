<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'cause_id',
        'title',
        'slug',
        'content', // Removed 'photo' as you are using the morph relationship
    ];

    /**
     * Get the user that authored the blog.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cause associated with the blog.
     */
    public function cause(): BelongsTo
    {
        return $this->belongsTo(Cause::class);
    }

    /**
     * Get the blog's photo (Polymorphic).
     */
    public function blogPhoto(): MorphOne
    {
        return $this->morphOne(Photo::class, 'imageable');
    }

    /**
     * Get the likes for the blog.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the comments for the blog.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}