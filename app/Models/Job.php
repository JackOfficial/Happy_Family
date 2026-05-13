<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    public function category()
{
    return $this->belongsTo(JobCategory::class);
}

public function applications()
{
    return $this->hasMany(Application::class);
}

public function jobDescription()
{
    return $this->morphOne(Attachment::class, 'attachable')
                ->where('file_type', 'jd');
}

// Scope to show only open positions on the frontend
public function scopeActive($query)
{
    return $query->where('is_active', true)
                 ->where('deadline', '>=', now());
}
}
