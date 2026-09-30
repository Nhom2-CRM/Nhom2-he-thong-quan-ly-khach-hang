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
        $data = $request->validate(['email'=>['required','email'],'password'=>['required','string']]);
        $user = User::where('email',$data['email'])->first();
        if (!$user || !Hash::check($data['password'],$user->password)) {
            return response()->json(['success'=>false,'message'=>'Email hoặc mật khẩu không đúng.'],422);
        }
        if ($user->status !== 'active') {
            return response()->json(['success'=>false,'message'=>'Tài khoản chưa được kích hoạt hoặc đã bị vô hiệu hóa.'],403);
        }
        $session = $this->sessions->create($user);
        return response()->json(['success'=>true,'session_token'=>$session->token,'user'=>$user->only(['id','name','email','business_group','role','status'])]);
    }
    public function me(Request $request) { return response()->json(['success'=>true,'user'=>$request->attributes->get('current_user')->only(['id','name','email','business_group','role','status'])]); }
    public function logout(Request $request) { $this->sessions->revoke($request->attributes->get('current_session')); return response()->json(['success'=>true,'message'=>'Đăng xuất thành công.']); }
}
