<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Get the blogs associated with this category.
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id'); 
    }

    /**
     * Get the category's polymorphic photo.
     */
    public function categoryPhoto(): MorphOne
    {
        return $this->morphOne(Photo::class, 'imageable');
    }
}