<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimelineEntry extends Model
{
    protected $fillable = [
        'project_id',
        'date_label',
        'title',
        'description',
        'tag_text',
        'tag_color',
        'is_milestone'
    ];

    protected $casts = [
        'is_milestone' => 'boolean'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
