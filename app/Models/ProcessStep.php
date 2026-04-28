<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    protected $fillable = ['step_number', 'title', 'description', 'icon', 'duration', 'deliverables', 'order_index', 'is_active'];
    protected $casts = ['deliverables' => 'array', 'is_active' => 'boolean'];
}
