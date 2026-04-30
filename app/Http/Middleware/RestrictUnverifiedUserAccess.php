<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictUnverifiedUserAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->hasVerifiedEmail()) {
            return $next($request);
        }

        if ($request->routeIs([
            'car.show',
            'verification.notice',
            'verification.send',
            'verification.verify',
            'logout',
        ])) {
            return $next($request);
        }

        return redirect()->route('verification.notice');
    }
}
