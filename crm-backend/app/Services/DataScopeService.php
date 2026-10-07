<?php

namespace App\Services;

use App\Enums\DataScopeEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class DataScopeService
{
    public function applyScope(Builder $query, User $user, DataScopeEnum $scope): Builder
    {
        return match ($scope) {
            DataScopeEnum::OWN => $query->where('user_id', $user->id),
            DataScopeEnum::TEAM => $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('sales_team_id', $user->sales_team_id);
            }),
            DataScopeEnum::ALL => $query,
        };
    }
}