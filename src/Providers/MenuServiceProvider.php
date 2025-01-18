<?php

namespace CodeCoz\AimAdmin\Providers;

use CodeCoz\AimAdmin\Admin;
use CodeCoz\AimAdmin\MenuBuilder\AimAdminMenu;
use CodeCoz\AimAdmin\MenuBuilder\BuildingMenu;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        // Check if 'AimAdmin' configuration exists
        if (is_null($this->app['config']['aim-admin'])) {
            // Merge the package's default configuration if it doesn't exist
            $this->mergeConfigFrom(
                Admin::packagePath('config/aim-admin.php'),
                'aim-admin'
            );
        }

        // Register the service as a singleton
        $this->app->singleton(AimAdminMenu::class, function ($app) {
            $config = $app['config']->get('aim-admin.menu_filters', []);
            $events = $app['events'];

            return new AimAdminMenu($config, $events, $app);
        });
    }


    /**
     * Bootstrap the package's services.
     *
     * @return void
     */
    public function boot(Dispatcher $events, Repository $config)
    {
        $this->registerMenu($events, $config);
    }

    /**
     * Register the menu events handlers.
     *
     * @return void
     */
    private function registerMenu(Dispatcher $events, Repository $config)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) use ($config) {
            $menu = $config->get('aim-admin.menu', []);
            $menu = is_array($menu) ? $menu : [];
            $event->menu->add(...$menu);
        });
    }

}
