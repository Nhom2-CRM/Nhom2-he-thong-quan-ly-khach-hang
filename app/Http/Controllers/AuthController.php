<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private SessionService $sessionService)
    {
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::with(['roles', 'businessGroups'])->where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không đúng.',
            ], 422);
        }

        $session = $this->sessionService->create($user);

        return response()->json([
            'success' => true,
            'session_token' => $session->token,
            'user' => $this->userPayload($user),
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->attributes->get('current_user')->load(['roles', 'businessGroups']);

        return response()->json([
            'success' => true,
            'user' => $this->userPayload($user),
        ]);
    }

    public function logout(Request $request)
    {
        $this->sessionService->revoke($request->attributes->get('current_session'));

        return response()->json([
            'success' => true,
            'message' => 'Đăng xuất thành công.',
        ]);
    }

    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->map(fn ($role) => [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name,
            ])->values(),
            'business_groups' => $user->businessGroups->map(fn ($group) => [
                'id' => $group->id,
                'name' => $group->name,
            ])->values(),
        ];
    }
}
