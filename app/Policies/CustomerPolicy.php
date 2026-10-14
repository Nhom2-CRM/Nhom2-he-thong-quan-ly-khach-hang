<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy
{
    /**
     * Chỉ Trưởng nhóm trở lên được thực hiện gộp khách hàng[cite: 1]
     */
    public function merge(User $user): bool
    {
        return in_array($user->role, ['team_lead', 'manager', 'admin'], true);
    }
}