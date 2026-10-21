<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDataScope
{
<<<<<<< HEAD
    public function handle(Request $request, Closure $next, string $scopeRequired): Response
    {
        $user = $request->user();

        // Kiểm tra quyền hạn phạm vi dữ liệu người dùng
        if (!$user || !$user->hasScopeAccess($scopeRequired)) {
            return response()->json(['message' => 'Bạn không có quyền truy cập phạm vi dữ liệu này.'], 403);
        }

=======
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->attributes->set('data_scope', $user->data_scope);

>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
        return $next($request);
    }
}