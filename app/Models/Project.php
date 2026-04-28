<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'name',
        'url_slug',
        'type',
        'client_name',
        'site_url',
        'start_date',
        'finish_date',
        'total_time',
        'team',
        'status',
        'delivered_on_time',
        'hero_image_path',
        'logo_image_path',
        'overview_heading',
        'overview_p1',
        'overview_p2',
        'overview_p3',
        'stat1_num',
        'stat1_lbl',
        'stat2_num',
        'stat2_lbl',
        'stat3_num',
        'stat3_lbl',
        'stack_description',
        'timeline_heading',
        'timeline_subtext',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image_url',
        'twitter_card',
        'seo_index',
        'show_portfolio',
        'is_featured',
        'visibility',
        'publish_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'finish_date' => 'date',
        'publish_at' => 'date',
        'delivered_on_time' => 'boolean',
        'seo_index' => 'boolean',
        'show_portfolio' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function challenges(): HasMany
    {
        return $this->hasMany(Challenge::class);
    }

    public function timelineEntries(): HasMany
    {
        return $this->hasMany(TimelineEntry::class);
    }

    public function relatedProjects(): HasMany
    {
        return $this->hasMany(RelatedProject::class);
    }

    public function techTags(): BelongsToMany
    {
        return $this->belongsToMany(TechTag::class, 'project_tech_tag');
    }

    public function serviceTags(): BelongsToMany
    {
        return $this->belongsToMany(ServiceTag::class, 'project_service_tag');
    }

    public function getLogoImageUrlAttribute(): ?string
    {
        return $this->normalizeImagePath($this->logo_image_path);
    }

    public function getHeroImageUrlAttribute(): ?string
    {
        return $this->normalizeImagePath($this->hero_image_path);
    }

    public function getDisplayImageUrlAttribute(): ?string
    {
        return $this->logo_image_url ?: $this->hero_image_url;
    }

    private function normalizeImagePath(?string $path): ?string
    {
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

        return asset('storage/' . ltrim($path, '/'));
    }
}
