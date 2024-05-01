<?php

namespace CodeCoz\AimAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        // Check for role
        if (!$request->user()->hasRole($role)) {
            // If role is not present, then check for permission
            if ($permission === null || !$request->user()->can($permission)) {
                // If permission is also not present, abort with 401 Unauthorized
                abort(401);
            }
        }

        return $next($request);
    }

}
