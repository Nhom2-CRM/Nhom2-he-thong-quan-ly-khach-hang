<?php

namespace App\Repositories\Eloquent;

use App\Models\Activity;
use App\Repositories\Contracts\ActivityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ActivityRepository implements ActivityRepositoryInterface
{
    public function getForUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return Activity::query()
            ->with(['customer', 'opportunity', 'assignedTo', 'createdBy'])
            ->where('assigned_to_user_id', $userId)
            ->orderBy('due_date', 'asc')
            ->paginate($perPage);
    }

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function updateStatus(Activity $activity, string $status, ?string $postponeReason = null): Activity
    {
        $activity->update([
            'status' => $status,
            'postpone_reason' => $status === 'postponed' ? $postponeReason : null,
        ]);

        return $activity;
    }
}