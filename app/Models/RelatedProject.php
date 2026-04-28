<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class RelatedProject extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'category',
        'description',
        'image_path',
        'link_url'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        $path = $this->image_path;
        if (!$path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        if (Str::startsWith($path, ['/'])) {
            return asset(ltrim($path, '/'));
        }

        if (Str::startsWith($path, ['images/', 'img/', 'assets/'])) {
            return asset($path);
        }

        // Default to public storage for uploaded assets.
        return asset('storage/' . ltrim($path, '/'));
    }
}
