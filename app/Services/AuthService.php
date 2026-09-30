<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Authenticate user credentials.
     *
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    public function login(array $credentials): array
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        $user = Auth::user();

        return [
            'user' => $user,
            'message' => 'Đăng nhập thành công.',
        ];
    }

    /**
     * Log the current user out.
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Send password reset link email.
     *
     * @param array $credentials
     * @return string
     * @throws ValidationException
     */
    public function sendResetLink(array $credentials): string
    {
        $status = Password::sendResetLink($credentials);

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return __($status);
    }

    /**
     * Reset user password using token.
     *
     * @param array $credentials
     * @return string
     * @throws ValidationException
     */
    public function resetPassword(array $credentials): string
    {
        $status = Password::reset($credentials, function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        });

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return __($status);
    }
    public function createApiToken(User $user): string
    {
        $plainToken = bin2hex(random_bytes(32));
        $user->apiTokens()->create([
            'token_hash' => hash('sha256', $plainToken),
            'expires_at' => now()->addHours(8),
        ]);
        return $plainToken;
    }

    public function revokeApiToken(?string $plainToken): void
    {
        if ($plainToken) {
            \App\Models\ApiToken::where('token_hash', hash('sha256', $plainToken))->delete();
        }
    }

}
