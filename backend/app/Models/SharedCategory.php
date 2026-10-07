<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedCategory extends Model
{
    protected $table = 'shared_categories';

    protected $fillable = [
        'type',
        'code',
        'name',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
