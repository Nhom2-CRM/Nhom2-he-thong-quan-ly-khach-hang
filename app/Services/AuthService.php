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
        Password::sendResetLink($credentials);

        return 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi liên kết đặt lại mật khẩu.';
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
}
