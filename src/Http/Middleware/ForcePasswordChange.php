<?php

namespace CodeCoz\AimAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldRedirectToPasswordChange($request)) {
            return redirect('profile/password/change');
        }

        return $next($request);
    }

    /**
     * Check if the user must be redirected to password change.
     *
     * @param Request $request
     * @return bool
     */
    private function shouldRedirectToPasswordChange(Request $request): bool
    {
        return Auth::check() &&
            $this->mustChangePassword() &&
            !$this->isPasswordChangeRoute($request);
    }

    /**
     * Check if the user must change the password.
     *
     * @return bool
     */
    private function mustChangePassword(): bool
    {
        return Auth::user()->isMustChangePassword == 1;
    }

    /**
     * Check if the current route is the password change route.
     *
     * @param Request $request
     * @return bool
     */
    private function isPasswordChangeRoute(Request $request): bool
    {
        return $request->route()->named('password.change'); // Assuming you have named your route 'password.change'
    }
}
