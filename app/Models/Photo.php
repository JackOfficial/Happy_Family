<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['file_path', 'caption', 'imageable_id', 'imageable_type'];

    /**
     * Get the parent imageable model (Cause, Project, etc.).
     */
    public function imageable() {
        return $this->morphTo();
    }

    /**
     * Accessor: Get the full URL for the photo.
     * Usage in Blade: {{ $photo->url }}
     */
    public function getUrlAttribute()
    {
        return $this->file_path ? Storage::disk('public')->url($this->file_path) : asset('images/placeholder.jpg');
    }
}