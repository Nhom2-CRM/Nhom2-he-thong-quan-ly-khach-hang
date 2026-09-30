<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(private SessionService $sessions) {}

    public function login(Request $request)
    {
        $data = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Email hoặc mật khẩu không chính xác.'], 422);
        }

        $session = $this->sessions->create($user);
        return response()->json([
            'success' => true,
            'session_token' => $session->token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'scope' => $user->data_scope,
                'business_group_id' => $user->business_group_id,
            ],
        ]);
    }
}
