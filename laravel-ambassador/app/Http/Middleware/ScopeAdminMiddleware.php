<?php

namespace App\Http\Middleware;

use Services\UserService;
use Closure;
use Illuminate\Http\Request;

class ScopeAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = (new UserService)->getRequest('get', '/scope/admin');
        if(!$response->ok()) {
            abort(401, 'unauthorized');
        }


        return $next($request);
    }
}
