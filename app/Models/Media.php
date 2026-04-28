<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'image_path',
        'category',
        'project_id'
    ];

    /**
     * Get the project that owns the media.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
