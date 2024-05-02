<?php

namespace CodeCoz\AimAdmin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function registration()
    {
        return view('aimadmin::auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required', 'max:254'],
            'email' => ['required', Rule::unique('users')],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);

        $user = User::create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
        ]);

        if ($user) {
            Auth::login($user);
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
