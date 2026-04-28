<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = ['page_id', 'section_key', 'content', 'sort_order', 'is_active'];

    protected $casts = [
        'content' => 'array', // Use 'array' cast for JSON in Laravel
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
