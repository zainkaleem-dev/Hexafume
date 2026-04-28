<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'icon', 'features', 'order_index', 'is_active'];
    protected $casts = ['features' => 'array', 'is_active' => 'boolean'];
}
