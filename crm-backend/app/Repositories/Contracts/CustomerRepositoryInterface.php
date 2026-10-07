<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Enums\DataScopeEnum;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{
    public function getPaginated(User $user, DataScopeEnum $scope, int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): mixed;
}