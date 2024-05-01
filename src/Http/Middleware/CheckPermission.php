<?php

namespace CodeCoz\AimAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use CodeCoz\AimAdmin\Traits\HelperTrait;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    use HelperTrait;

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (Auth::check() && (Auth::user()->isSuperAdmin() || $this->checkPermission($permission))) {
            return $next($request);
        }
        return to_route('home')->with('error', 'Unauthorized !');
    }

}
