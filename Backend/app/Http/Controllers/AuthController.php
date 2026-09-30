<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->email,
            $request->password
        );

        // Nếu đăng nhập thất bại
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], $result['status']);
        }

        $user = $result['user'];

        // Chọn trang chủ theo vai trò
        $redirect = match ($user->role) {
            'admin' => '/admin/dashboard',
            'staff' => '/dashboard',
            default => '/dashboard',
        };

        return response()->json([
            'success' => true,
            'message' => 'Đăng nhập thành công.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'redirect' => $redirect,
        ]);
    }
}