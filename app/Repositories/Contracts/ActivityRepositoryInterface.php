<?php

namespace App\Repositories\Contracts;

use App\Models\Activity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ActivityRepositoryInterface
{
    public function getForUser(int $userId, int $perPage = 15): LengthAwarePaginator;

    public function create(array $data): Activity;

    public function updateStatus(Activity $activity, string $status, ?string $postponeReason = null): Activity;
}