<?php

namespace CodeCoz\AimAdmin\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use CodeCoz\AimAdmin\Driver\AimAdminUserProviderDriver;
use CodeCoz\AimAdmin\Guard\AimGuard;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {

    }


    /**
     * Bootstrap the package's services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerUserProviderDriver();
        $this->registerGuard();
    }

    /**
     * Register the User Provider handlers.
     *
     * @return void
     */
    private function registerUserProviderDriver(): void
    {
        Auth::provider('AimAdminUserProviderDriver', function ($app, array $config) {
            return new AimAdminUserProviderDriver();
        });

        //      Overriding the default users driver
        config([
            'auth.providers.users.driver' => env('USER_PROVIDER_DRIVER', 'AimAdminUserProviderDriver')
        ]);
    }

    /**
     * Register the Guard handlers.
     *
     * @return void
     */
    private function registerGuard(): void
    {
        Auth::extend('AimAdminGuard', function ($app, $config) {
            return new AimGuard(
                Auth::createUserProvider('users'),
                $app['request'],
                $app['session.store']
            );
        });

        //      Overriding the default guard configuration
        config([
            'auth.guards.web.driver' => env('DEFAULT_GUARD', 'AimAdminGuard')
        ]);
    }

}
