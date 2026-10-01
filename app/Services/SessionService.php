<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SessionService
{
    private int $sessionMinutes = 30;

    public function create(User $user): UserSession
    {
        return UserSession::create([
            'user_id' => $user->id,
            'token' => hash('sha256', Str::random(80)),
            'last_activity' => now(),
            'expires_at' => now()->addMinutes($this->sessionMinutes),
            'revoked' => false,
        ]);
    }

    public function validate(string $token): ?UserSession
    {
        $session = UserSession::with('user')->where('token', $token)->first();
        if (!$session || $session->revoked || Carbon::now()->greaterThan($session->expires_at)) {
            return null;
        }
        return $session;
    }

    public function refresh(UserSession $session): void
    {
        $session->update([
            'last_activity' => now(),
            'expires_at' => now()->addMinutes($this->sessionMinutes),
        ]);
    }
}
