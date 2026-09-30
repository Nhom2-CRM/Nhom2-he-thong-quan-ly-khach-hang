<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private SessionService $sessionService)
    {
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Za-z])(?=.*\d).+$/',
                'confirmed',
            ],
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.min' => 'Mật khẩu mới phải có tối thiểu 8 ký tự.',
            'new_password.regex' => 'Mật khẩu mới phải chứa cả chữ và số.',
            'new_password.confirmed' => 'Xác nhận mật khẩu mới không khớp.',
        ]);

        /** @var User|null $user */
        $user = $request->attributes->get('current_user');

        /** @var UserSession|null $currentSession */
        $currentSession = $request->attributes->get('current_session');

        if (!$user || !$currentSession) {
            return response()->json([
                'success' => false,
                'code' => 'SESSION_EXPIRED',
                'message' => 'Phiên đăng nhập không hợp lệ.',
            ], 401);
        }

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu hiện tại không chính xác.',
            ], 422);
        }

        $user->password = $validated['new_password'];
        $user->save();

        $revokedSessions = $this->sessionService->revokeOtherSessions($user, $currentSession);

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công. Các phiên đăng nhập khác đã được thu hồi.',
            'revoked_sessions' => $revokedSessions,
        ]);
    }
}
