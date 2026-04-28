<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'status', 'author', 'description',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image_url', 'is_published'
    ];

    public function sections()
    {
        return $this->hasMany(PageSection::class)->orderBy('sort_order');
    }

    /**
     * Helper to get section content by key
     */
    public function getSectionContent($key, $default = [])
    {
        $section = $this->sections()->where('section_key', $key)->first();
        return $section ? $section->content : $default;
    }
}
