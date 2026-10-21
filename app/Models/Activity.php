<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Activity extends Model
{
    //
}
=======
=======
use App\Enums\ActivityPriorityEnum;
use App\Enums\ActivityStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
>>>>>>> feature/S6-06-activity-backend
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
<<<<<<< HEAD
    protected $fillable = ['user_id', 'lead_id', 'customer_id', 'type', 'description', 'scheduled_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
=======
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
>>>>>>> feature/S6-06-activity-backend
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
<<<<<<< HEAD
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
=======

    public function opportunity(): BelongsTo
    {
        return $this->belongsTo(Opportunity::class);
    }
}
>>>>>>> feature/S6-06-activity-backend
