<?php

namespace CodeCoz\AimAdmin\Driver;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class AimAdminUserProviderDriver implements UserProvider
{
    public function retrieveById($identifier)
    {
        $user = session('user');
        if ($user && $user['id'] == $identifier) {
            return $user;
        }
        return null;
    }
    public function retrieveByCredentials(array $credentials)
    {
        $user = session('user');
        if ($user && $user['user_name'] === $credentials['user_name']) {
            return $user;
        }
        return null;
    }

    public function retrieveByToken($identifier, $token)
    {
        $user = session('user');
        if ($user && $user['id'] == $identifier && $user['remember_token'] == $token) {
            return $user;
        }
        return null;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        try {
            return $user->is_successful ?? true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        $userData = session('user');
        if ($userData && $userData['id'] == $user->getAuthIdentifier()) {
            $userData['remember_token'] = $token;
            session(['user' => $userData]);
        }
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {

    }
}
