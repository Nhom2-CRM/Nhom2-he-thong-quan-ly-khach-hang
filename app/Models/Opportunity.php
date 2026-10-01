<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $fillable = ['title', 'amount', 'status', 'owner_id'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2'];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
