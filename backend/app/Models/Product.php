<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'type',
        'unit',
        'list_price',
        'floor_price',
        'cost_price',
        'description',
        'is_active',
    ];

    protected $casts = [
        'list_price' => 'decimal:2',
        'floor_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}