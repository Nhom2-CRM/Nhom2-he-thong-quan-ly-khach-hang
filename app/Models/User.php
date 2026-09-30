<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Các trường được phép mass-assign.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // 'admin' | 'manager' | 'staff'
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'assigned_to');
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(Campaign::class, 'created_by');
    }

    // -------------------------------------------------------------------------
    // Permission helpers (dùng bởi CheckPermission middleware)
    // -------------------------------------------------------------------------

    /**
     * Kiểm tra user có quyền $permission không.
     * Mapping đơn giản dựa trên cột `role`.
     */
    public function can(string $ability, mixed $arguments = []): bool
    {
        $rolePermissions = [
            'admin'   => ['manage-users', 'manage-customers', 'manage-campaigns', 'view-reports'],
            'manager' => ['manage-customers', 'manage-campaigns', 'view-reports'],
            'staff'   => ['manage-customers'],
        ];

        return in_array($ability, $rolePermissions[$this->role] ?? [], true);
    }

    // -------------------------------------------------------------------------
    // Scopes
    // -------------------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
