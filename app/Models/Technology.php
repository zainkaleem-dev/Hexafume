<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
    protected $fillable = ['name', 'category', 'icon', 'order_index', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}
