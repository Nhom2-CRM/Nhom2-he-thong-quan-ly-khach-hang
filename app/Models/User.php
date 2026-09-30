<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'locked_at'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'locked_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'owner_id');
    }

    public function opportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class, 'owner_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(UserSession::class);
    }

    public function isLocked(): bool
    {
        return $this->locked_at !== null;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
