<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> feature/S6-06-activity-backend

class Lead extends Model
{
    //
}
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'title',
        'region',
        'industry',
        'status',
        'assigned_to',
        'notes',
    ];

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
=======
>>>>>>> feature/S6-06-activity-backend
