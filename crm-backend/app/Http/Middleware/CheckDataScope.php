<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\DataScopeEnum;
use Symfony\Component\HttpFoundation\Response;

class CheckDataScope
{
    public function handle(Request $request, Closure $next): Response
    {
        $scopeHeader = $request->header('X-Data-Scope', 'own');
        $scope = DataScopeEnum::tryFrom($scopeHeader) ?? DataScopeEnum::OWN;

        $request->attributes->set('data_scope', $scope);

        return $next($request);
    }
}