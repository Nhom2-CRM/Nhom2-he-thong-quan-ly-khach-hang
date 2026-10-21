<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    public function updateStatus(User $user, Activity $activity): bool
    {
        return $user->id === $activity->assigned_to_user_id || $user->id === $activity->created_by_user_id;
    }
}