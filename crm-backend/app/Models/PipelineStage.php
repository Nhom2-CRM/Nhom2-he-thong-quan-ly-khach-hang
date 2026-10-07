<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PipelineStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'win_probability',
        'exit_requirements',
    ];

    protected $casts = [
        'exit_requirements' => 'array',
    ];
}