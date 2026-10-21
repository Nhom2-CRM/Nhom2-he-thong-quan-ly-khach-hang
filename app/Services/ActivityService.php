<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\User;
use App\Repositories\Contracts\ActivityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ActivityService
{
    public function __construct(
        protected ActivityRepositoryInterface $activityRepository
    ) {}

    public function getUserActivities(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return $this->activityRepository->getForUser($user->id, $perPage);
    }

    public function createActivity(User $creator, array $data): Activity
    {
        $data['created_by_user_id'] = $creator->id;

        return $this->activityRepository->create($data);
    }

    public function changeActivityStatus(Activity $activity, string $status, ?string $postponeReason = null): Activity
    {
        return $this->activityRepository->updateStatus($activity, $status, $postponeReason);
    }
}