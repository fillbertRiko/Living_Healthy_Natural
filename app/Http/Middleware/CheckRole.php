<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
