<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    protected $fillable = [
        'quote',
        'initials',
        'company',
        'role',
        'client_name',
        'location',
        'photo',
        'order_index',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo) {
            return null;
        }

        if (Str::startsWith($this->photo, ['http://', 'https://', '//'])) {
            return $this->photo;
        }

        if (Str::startsWith($this->photo, 'storage/')) {
            return asset($this->photo);
        }

        if (Str::startsWith($this->photo, ['/'])) {
            return asset(ltrim($this->photo, '/'));
        }

        return asset('storage/' . ltrim($this->photo, '/'));
    }
}
