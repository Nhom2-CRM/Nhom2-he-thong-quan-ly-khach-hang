<?php

namespace App\Policies;

use App\Models\Opportunity;
use App\Models\User;
use App\Enums\DataScopeEnum;

class OpportunityPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Opportunity $opportunity): bool
    {
        return match ($user->data_scope) {
            DataScopeEnum::ALL->value => true,
            DataScopeEnum::DEPARTMENT->value => in_array($opportunity->assigned_to, $user->departmentUserIds()),
            DataScopeEnum::PERSONAL->value => $opportunity->assigned_to === $user->id,
            default => false,
        };
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Opportunity $opportunity): bool
    {
        return $user->id === $opportunity->assigned_to || $user->is_admin;
    }

    public function delete(User $user, Opportunity $opportunity): bool
    {
        return (bool) $user->is_admin;
    }
}