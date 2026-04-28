<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'url_slug',
        'initials',
        'title',
        'dept',
        'dept_label',
        'exp',
        'location',
        'bio',
        'photo_path',
        'email',
        'linkedin',
        'twitter',
        'github',
        'skills',
        'expertise_tags',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_image_url',
        'seo_index',
        'show_on_team',
        'is_featured',
        'visibility',
        'publish_at',
    ];

    protected $casts = [
        'skills' => 'array',
        'expertise_tags' => 'array',
        'publish_at' => 'date',
        'seo_index' => 'boolean',
        'show_on_team' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function qualifications(): HasMany
    {
        return $this->hasMany(TeamMemberQualification::class)->orderBy('sort_order');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(TeamMemberAchievement::class)->orderBy('sort_order');
    }
}
