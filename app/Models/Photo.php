<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Photo extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'file_path', 
        'caption', 
        'file_size', 
        'file_type', 
        'imageable_id', 
        'imageable_type'
    ];

    /**
     * Get the parent imageable model (Cause, Project, etc.).
     */
    public function imageable() 
    {
        return $this->morphTo();
    }

    /**
     * Accessor: Get the full URL for the photo.
     * Usage in Blade: {{ $photo->url }}
     */
    protected function url(): Attribute
    {
        return Attribute::get(fn () => 
            $this->file_path 
                ? Storage::disk('public')->url($this->file_path) 
                : asset('images/placeholder.jpg')
        );
    }

    /**
     * Accessor: Get human-readable file size.
     * Usage in Blade: {{ $photo->readable_size }}
     */
    protected function readableSize(): Attribute
    {
        return Attribute::get(function () {
            $bytes = $this->file_size ?? 0;
            $units = ['B', 'KB', 'MB', 'GB'];
            for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                $bytes /= 1024;
            }
            return round($bytes, 2) . ' ' . $units[$i];
        });
    }
}