<?php

namespace App\Models;

use App\Enums\ActivityPriorityEnum;
use App\Enums\ActivityStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'due_date',
        'priority',
        'status',
        'postpone_reason',
        'assigned_to_user_id',
        'created_by_user_id',
        'customer_id',
        'opportunity_id',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'priority' => ActivityPriorityEnum::class,
        'status' => ActivityStatusEnum::class,
    ];

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }
}