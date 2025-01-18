<?php

declare(strict_types=1);

/*
 * This file is part of the AimAdmin package.
 *
 * (c) CodeCoz <contact@codecoz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CodeCoz\AimAdmin\Guard;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

/**
 * This is admin gurard class used for authentication
 *
 * @author Muhammad Abdullah Ibne Masud <abdullah.masud@banglalink.net>
 */

class AimGuard implements Guard
{
    protected $user;
    protected $provider;
    protected $session;
    protected $request;

    public function __construct(UserProvider $provider, Request $request, Session $session)
    {
        $this->provider = $provider;
        $this->request = $request;
        $this->session = $session;
    }

    public function check(): bool
    {
        return !is_null($this->user());
    }

    public function guest(): bool
    {
        return !$this->check();
    }

    public function user()
    {
        if (isset($this->user)) {
            return $this->user;
        }

        $user = $this->session->get('user');

        if (!is_null($user)) {
            $this->user = $this->provider->retrieveById($user['id']);
            return $this->user;
        }

        return null;
    }


    public function id()
    {
        if ($this->user()) {
            return $this->user->getAuthIdentifier();
        }
        return null;
    }

    public function validate(array $credentials = [])
    {
        $user = $this->provider->retrieveByCredentials($credentials);

        if ($user && $this->provider->validateCredentials($user, $credentials)) {
            $this->session->put('user_id', $user->getAuthIdentifier());
            $this->setUser($user);
            return true;
        }

        return false;
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
        return $this;
    }

    public function hasUser()
    {
        if ($this->user()) {
            return true;
        }
        return false;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
        $this->session->remove('user_id');
    }
}
