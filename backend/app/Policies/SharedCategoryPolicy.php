<?php

namespace App\Policies;

use App\Models\SharedCategory;
use App\Models\User;

class SharedCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SharedCategory $category): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SharedCategory $category): bool
    {
        return true;
    }

    public function delete(User $user, SharedCategory $category): bool
    {
        return true;
    }
}