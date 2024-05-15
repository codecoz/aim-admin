<?php

namespace CodeCoz\AimAdmin;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use CodeCoz\AimAdmin\Console\Commands\MakeAimController;
use CodeCoz\AimAdmin\Console\Commands\MakeAimRepository;
use CodeCoz\AimAdmin\Console\Commands\MakeAimRepositoryInterface;
use CodeCoz\AimAdmin\Console\Commands\MakeAimService;
use CodeCoz\AimAdmin\Console\Commands\MakeAimServiceInterface;
use CodeCoz\AimAdmin\Console\Commands\AimAdminCommand;
use CodeCoz\AimAdmin\Console\Commands\AddToRouteCommand;
use CodeCoz\AimAdmin\Console\InstallAimAdminCommand;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudBoardInterface;
use CodeCoz\AimAdmin\Providers\MenuServiceProvider;
use CodeCoz\AimAdmin\Providers\RepositoryServiceProvider;
use CodeCoz\AimAdmin\Providers\UserServiceProvider;
use CodeCoz\AimAdmin\Services\CrudBoard\CrudBoard;
use Illuminate\Contracts\View\Factory;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * The prefix to use for register/load the package resources.
     *
     * @var string
     */
    protected string $packagePrefix = 'aim-admin';
    private string $viewsPath;
    private string $configPath;
    private string $routePath;
    private string $migrationPath;


    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {

        $this->viewsPath = Admin::packagePath('resources/views');
        $this->configPath = Admin::packagePath('config/aim-admin.php');
        $this->routePath = Admin::packagePath('routes/web.php');
        $this->migrationPath = Admin::packagePath('database/migrations');

        // Internal Interfaces Bindings.
        $this->interfacesBindings();

        // Register user service provider.
//        $this->app->register(UserServiceProvider::class);

        // Register the Menu service provider.
        $this->app->register(MenuServiceProvider::class);

        // Register the Repo service provider.
        $this->app->register(RepositoryServiceProvider::class);

        // cd pa$this->callAfterResolving('blade.compiler', fn(BladeCompiler $bladeCompiler) => $this->registerBladeExtensions($bladeCompiler));

    }

    protected function registerBladeExtensions($bladeCompiler): void
    {
        $bladeMethodWrapper = '\\CodeCoz\\AimAdmin\\AdminServiceProvider::bladeMethodWrapper';

        $bladeCompiler->directive('hasanypermission', fn($args) => "<?php if({$bladeMethodWrapper}('hasAnyPermission', {$args})): ?>");
        $bladeCompiler->directive('elsehasanypermission', fn($args) => "<?php elseif({$bladeMethodWrapper}('hasAnyPermission', {$args})): ?>");
        $bladeCompiler->directive('endhasanypermission', fn() => '<?php endif; ?>');

        $bladeCompiler->directive('hasrole', fn($args) => "<?php if({$bladeMethodWrapper}('hasRole', {$args})): ?>");
        $bladeCompiler->directive('endhasrole', fn() => '<?php endif; ?>');

        $bladeCompiler->directive('hasanyrole', fn($args) => "<?php if({$bladeMethodWrapper}('hasAnyRole', {$args})): ?>");
        $bladeCompiler->directive('endhasanyrole', fn() => '<?php endif; ?>');

    }

    public static function bladeMethodWrapper($method, $role, $guard = null): bool
    {
        return true;
    }

    /**
     * Interfaces bindings
     *
     * @return void
     */
    private function interfacesBindings(): void
    {
        // Register the service the package provides.
        $this->app->singleton($this->packagePrefix, function ($app) {
            return new Admin;
        });

        // Register the extra Interfaces to the package provides.
        $this->app->singleton(CrudBoardInterface::class, CrudBoard::class);

    }

    /**
     * Perform post-registration booting of services.
     *
     * @param Factory $view
     * @return void
     */
    public function boot(Factory $view): void
    {
        $this->loadConfig();
        $this->loadViews();
        $this->loadRoutes();
        $this->loadMigration();
        $this->loadBladeComponentNamespace();
        $this->registerCommands();
        $this->registerGlobalMiddleware();
        Paginator::useBootstrapFour();

        $this->publishMigrations();

    }

    /**
     * Load the Blade Component Namespace.
     *
     * @return void
     */
    private function loadBladeComponentNamespace(): void
    {
        Blade::componentNamespace('CodeCoz\\AimAdmin\View\\Components', $this->packagePrefix);
        Blade::anonymousComponentPath($this->viewsPath, $this->packagePrefix);
    }


    /**
     * Load the package views.
     *
     * @return void
     */
    private function loadViews(): void
    {
        // Use the default package views path
        $this->loadViewsFrom($this->viewsPath, $this->packagePrefix);
    }

    /**
     * Publish the migrations.
     *
     * @return void
     */
    private function publishMigrations(): void
    {

        $this->publishes([$this->migrationPath => database_path('migrations'),
        ], 'migrations');

    }

    /**
     * Load the package config.
     *
     * @return void
     */
    private function loadConfig(): void
    {
        $this->mergeConfigFrom($this->configPath, $this->packagePrefix);
    }

    /**
     *  Load the package routes.
     * @return void
     */
    private function loadRoutes(): void
    {
        $this->loadRoutesFrom($this->routePath);
    }

    /**
     *  Load the package migration.
     * @return void
     */
    private function loadMigration(): void
    {
        $this->loadMigrationsFrom($this->migrationPath);
    }


    /**
     * Register the package's Global Middleware.
     *
     * @return void
     */
    private function registerGlobalMiddleware(): void
    {
//        $this->app['router']->aliasMiddleware('role', RoleMiddleware::class);
//        $this->app['router']->aliasMiddleware('acl', CheckPermission::class);
//        $this->app['router']->pushMiddlewareToGroup('web', ForcePasswordChange::class);
    }

    /**
     * Register the package's artisan commands.
     *
     * @return void
     */
    private function registerCommands(): void
    {
        $this->commands([
            InstallAimAdminCommand::class,
            MakeAimController::class,
            MakeAimRepositoryInterface::class,
            MakeAimServiceInterface::class,
            MakeAimRepository::class,
            MakeAimService::class,
            AimAdminCommand::class,
            AddToRouteCommand::class,
        ]);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [$this->packagePrefix];
    }

}
