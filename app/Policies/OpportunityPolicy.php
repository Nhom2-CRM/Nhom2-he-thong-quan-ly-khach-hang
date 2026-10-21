<?php

namespace App\Policies;

use App\Models\Opportunity;
use App\Models\User;
<<<<<<< HEAD
use Illuminate\Auth\Access\Response;

class OpportunityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Opportunity $opportunity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Opportunity $opportunity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Opportunity $opportunity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Opportunity $opportunity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Opportunity $opportunity): bool
    {
        return false;
    }
}
=======
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
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
