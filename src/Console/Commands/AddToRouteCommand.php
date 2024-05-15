<?php

namespace CodeCoz\AimAdmin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AddToRouteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aim-admin:add-to-route {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add to Route';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = strtolower($this->argument('name'));
        $controllerName = ucfirst($name) . 'Controller';

        $routes = <<<EOT
        Route::group(['prefix' => '{$name}', 'middleware' => ['web', 'auth']], function () {
            Route::get('/', [{$controllerName}::class, 'list'])->name('{$name}.list');
            Route::get('/show/{id}', [{$controllerName}::class, 'show'])->name('{$name}.show');
            Route::get('/edit/{id}', [{$controllerName}::class, 'edit'])->name('{$name}.edit');
            Route::post('/update', [{$controllerName}::class, 'update'])->name('{$name}.update');
            Route::post('/delete/{id}', [{$controllerName}::class, 'delete'])->name('{$name}.delete');
            Route::get('/create', [{$controllerName}::class, 'create'])->name('{$name}.create');
            Route::post('/create', [{$controllerName}::class, 'store'])->name('{$name}.store');
        });
        EOT;
        $routeFile = base_path('routes/web.php');
        $currentRoutes = File::get($routeFile);
        if (!str_contains($currentRoutes, $routes)) {
            if (File::append($routeFile, "\n" . $routes)) {
                $this->info(ucfirst($name) . ' routes have been added successfully.');
            } else {
                $this->error('Failed to add ' . $name . ' routes.');
            }
        } else {
            $this->info('The routes for ' . ucfirst($name) . ' already exist in the routes file.');
        }
    }

}
