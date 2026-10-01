<?php

use App\Http\Middleware\CheckPermission;
use App\Services\ErrorActionResolver;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'permission' => CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        /*
         | S1-07: mọi lỗi điều hướng quan trọng đi qua một giao diện dùng chung.
         | API trả JSON để React hiển thị ErrorPage, web trả Blade errors.show.
         */
        $exceptions->render(function (\Throwable $e, Request $request) {
            $statusCode = resolveStatusCode($e);

            // Giữ nguyên validation 422 và các lỗi HTTP ngoài phạm vi S1-07.
            if ($statusCode === null) {
                return null;
            }

            $action = app(ErrorActionResolver::class)->resolve($statusCode, $request);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => [
                        'status_code' => $statusCode,
                        'title' => $action['title'],
                        'message' => $action['message'],
                        'primary_action' => $action['primary_action'],
                        'secondary_action' => $action['secondary_action'],
                    ],
                ], $statusCode);
            }

            return response()->view('errors.show', [
                'statusCode' => $statusCode,
                'action' => $action,
            ], $statusCode);
        });

        $exceptions->dontFlash([
            'current_password',
            'password',
            'password_confirmation',
        ]);
    })
    ->create();

/**
 * Map exception sang mã lỗi cần dùng trang lỗi chung.
 * ValidationException vẫn để Laravel xử lý 422 bình thường.
 * Exception không xác định được coi là lỗi hệ thống 500.
 */
function resolveStatusCode(\Throwable $e): ?int
{
    return match (true) {
        $e instanceof ValidationException => null,
        $e instanceof AuthenticationException => 401,
        $e instanceof AuthorizationException => 403,
        $e instanceof ModelNotFoundException => 404,
        $e instanceof TokenMismatchException => 419,
        $e instanceof HttpExceptionInterface => match ($e->getStatusCode()) {
            401, 403, 404, 419, 500 => $e->getStatusCode(),
            default => null,
        },
        default => 500,
    };
}
