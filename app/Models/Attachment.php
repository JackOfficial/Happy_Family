<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    protected $fillable = [
        'attachable_id',
        'attachable_type',
        'file_path',
        'file_name',
        'file_type'
    ];

    /**
     * Get the parent model (Application, User, Project, etc.)
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
