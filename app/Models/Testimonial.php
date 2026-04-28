<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['quote', 'initials', 'company', 'role', 'order_index', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
