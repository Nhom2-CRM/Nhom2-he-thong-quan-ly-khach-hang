<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDataScope
{
    public function handle(Request $request, Closure $next, string $scopeRequired): Response
    {
        $user = $request->user();

        // Kiểm tra quyền hạn phạm vi dữ liệu người dùng
        if (!$user || !$user->hasScopeAccess($scopeRequired)) {
            return response()->json(['message' => 'Bạn không có quyền truy cập phạm vi dữ liệu này.'], 403);
        }

        return $next($request);
    }
}