<?php

namespace App\Services;

use App\Enums\DataScopeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class DataScopeService
{
    public function applyScope(Builder $query, User $user, string $userColumn = 'assigned_to'): Builder
    {
        $scope = $user->data_scope ?? DataScopeEnum::PERSONAL->value;

        return match ($scope) {
            DataScopeEnum::ALL->value => $query,
            DataScopeEnum::DEPARTMENT->value => $query->whereIn($userColumn, $user->departmentUserIds()),
            DataScopeEnum::PERSONAL->value => $query->where($userColumn, $user->id),
            default => $query->whereRaw('1 = 0'),
        };
    }
}