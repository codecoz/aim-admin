<?php

namespace CodeCoz\AimAdmin\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use CodeCoz\AimAdmin\Http\Requests\LoginRequest;
use CodeCoz\AimAdmin\Http\Requests\PasswordResetRequest;
use CodeCoz\AimAdmin\Services\Auth\LoginService;

class AuthController extends Controller
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function view()
    {
        if (Auth::check() && Route::has('home')) {
            return redirect()->route('home');
        }
        return view('aimadmin::auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            $this->loginService->userLogin($request);
            return redirect()->route('home');
        } catch (\Exception $e) {
            // Handle other errors
            return redirect()->back()->with('error', 'Invalid username/password.');
        }
    }


    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();

        return redirect('/login');
    }


    public function passwordReset($token)
    {
        return view('auth.password-reset', ['token' => $token]);
    }


    /**
     * @throws NotFoundException
     * @throws GuzzleException
     */
    public function reset(PasswordResetRequest $request)
    {
        $json = [
            "emailAddress" => $request->email,
            "password" => bcrypt($request->get('password')),
            'resetToken' => $request->token,
        ];

        $this->loginService->passwordReset($json);

        return redirect()->route('login')->with('success', 'Your password has been reset successfully. Please use your new password to log in.');
    }
}
