<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use App\Enums\DataScopeEnum;

class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Customer $customer): bool
    {
        if ($user->data_scope === DataScopeEnum::ALL->value) {
            return true;
        }

        return $customer->assigned_to === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->id === $customer->assigned_to || $user->is_admin;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return (bool) $user->is_admin;
    }
}