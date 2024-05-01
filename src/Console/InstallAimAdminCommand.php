<?php

namespace CodeCoz\AimAdmin\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use CodeCoz\AimAdmin\Admin;
use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Filesystem\Filesystem;

class InstallAimAdminCommand extends Command
{
    protected $signature = 'aim:install';

    protected $description = 'Install Aim Admin';

    /**
     * Handle the Full Installation
     * @return void
     */
    public function handle(): void
    {
        // Update npm packages
        if (!file_exists(base_path('package.json'))) {
            $this->error('package.json not found.');
            return;
        }

        // File path to the 'adminlte.js'
        $filePath = base_path('resources/js/app.js');

        // Check if the file exists
        if (!file_exists($filePath)) {
            $this->error("app.js File does not exist: {$filePath}");
            return;
        }

        self::makeFolders();
        $this->info('Contracts Folders have been created.');
//      self::replacePackageJson();
//      $this->info('Package.json has been replaced.');
        self::updatePackages();
        $this->info('package.json has been updated.');
        self::updateAimAdminAssets();
        $this->info('app.js has been updated.');
        self::exportConfig();
        $this->info('Aim Admin Config file has been exported.');
        self::exportMigrations();
        $this->info('Migrations have been exported.');
        self::exportModel();
        $this->info('User model has been exported.');
        self::addedHomeRoute();
        $this->info('Home route has been added.');
        self::addedHomeBlade();
        $this->info('Home blade has been added.');
        self::exportVite();
        $this->info('vite.config.js has been exported.');
        $this->info('Aim Admin has been installed successfully. Please run npm i && npm run build');
    }


    /**
     * Make the Contracts folders
     * @return void
     */
    protected static function makeFolders(): void
    {
        tap(new Filesystem, function ($filesystem) {

            $contractsServicesPath = app_path('Contracts/Services');
            if (!$filesystem->isDirectory($contractsServicesPath)) {
                $filesystem->makeDirectory($contractsServicesPath, 0755, true);
            }

            $contractsRepositoriesPath = app_path('Contracts/Repositories');
            if (!$filesystem->isDirectory($contractsRepositoriesPath)) {
                $filesystem->makeDirectory($contractsRepositoriesPath, 0755, true);
            }

            $repositoriesPath = app_path('Repositories');
            if (!$filesystem->isDirectory($repositoriesPath)) {
                $filesystem->makeDirectory($repositoriesPath, 0755, true);
            }

            $servicesPath = app_path('Services');
            if (!$filesystem->isDirectory($servicesPath)) {
                $filesystem->makeDirectory($servicesPath, 0755, true);
            }

        });

    }

    /**
     * @param array $packages
     * @param array $requiredPackages
     * @return array
     */
    protected static function updatePackageArray(array $packages, array $requiredPackages): array
    {
        foreach ($requiredPackages as $package => $version) {
            if (!array_key_exists($package, $packages)) {
                $packages[$package] = $version;
            }
        }

        return $packages;
    }

    /**
     * Replace the package.json in case of using webpack
     * @return void
     */
    protected static function replacePackageJson(): void
    {
        $filesystem = new Filesystem;

        $destinationPath = base_path('package.json');
        if ($filesystem->exists($destinationPath)) {
            $filesystem->delete($destinationPath);
        }

        $sourcePath = __DIR__ . '../../stubs/package.json';
        $filesystem->copy($sourcePath, $destinationPath);
    }

    /**
     * Merge package.json dependency
     * @return void
     */
    protected static function updatePackages(): void
    {
        $packagesFile = json_decode(file_get_contents(base_path('package.json')), true);

        $requiredPackages = [
            "@fortawesome/fontawesome-free" => "^6.5.2",
            "admin-lte" => "^3.2.0",
            "chart.js" => "^4.2.0",
            "jquery" => "^3.7.0",
            "flatpickr" => "^4.6.13",
            "sweetalert2" => "^11.8.0",
            "laravel-vite-plugin" => "^1.0.0",
            "vite-plugin-static-copy" => "^1.0.3",
            "sass" => "^1.74.1",
            "vite" => "^5.0.0",
        ];

        // Combine existing dependencies and devDependencies
        $existingPackages = array_merge(
            $packagesFile['dependencies'] ?? [],
            $packagesFile['devDependencies'] ?? []
        );

        // Filter out the required packages that already exist
        $packagesToAdd = array_diff_key($requiredPackages, $existingPackages);

        // Update devDependencies with the filtered packages
        $packagesFile['devDependencies'] = static::updatePackageArray(
            $packagesFile['devDependencies'] ?? [],
            $packagesToAdd
        );

        ksort($packagesFile['devDependencies']);

        file_put_contents(
            base_path('package.json'),
            json_encode($packagesFile, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    /**
     * Added the required assets for Aim Admin
     * @return void
     */
    protected static function updateAimAdminAssets(): void
    {
        // File path to the 'app.js'
        $appFilePath = base_path('resources/js/app.js');
        $boostrapFilePath = base_path('resources/js/bootstrap.js');

        // app.js  Line to be added
        $appLineToAdd = "import '../../vendor/codecoz/aim-admin/resources/js/adminlte.js';\n";
        $appLineToAdd .= "import '../../vendor/codecoz/aim-admin/resources/scss/adminlte.scss';\n";

        // Check if the import has already been added (using a more robust method)
        if (!self::hasImportBeenAdded($appFilePath, $appLineToAdd)) {
            // Append the line if it does not exist
            file_put_contents($appFilePath, $appLineToAdd, FILE_APPEND);
        }

        // bootstrap.js Line to be added
        $boostrapLineToAdd = "import $ from 'jquery';\n";
        $boostrapLineToAdd .= "window.$ = window.jQuery = $;\n";

        // Check if the import has already been added (using a more robust method)
        if (!self::hasImportBeenAdded($boostrapFilePath, $boostrapLineToAdd)) {
            // Append the line if it does not exist
            file_put_contents($boostrapFilePath, $boostrapLineToAdd, FILE_APPEND);
        }
    }

    /**
     * Export the Config file.
     */
    protected static function exportConfig(): void
    {
        copy(__DIR__ . '../../../config/aim-admin.php', base_path('config/aim-admin.php'));
    }

    /**
     * Export the migrations
     * @return void
     */
    protected static function exportMigrations(): void
    {
        $filesystem = new Filesystem();
        $sourcePath = Admin::packagePath('database/migrations');
        $destinationPath = database_path('migrations');

        // Check if the destination directory exists
        if ($filesystem->exists($destinationPath)) {
            // Delete the existing directory
            $filesystem->deleteDirectory($destinationPath);
        }

        if (!$filesystem->copyDirectory($sourcePath, $destinationPath)) {
            error_log("Failed to copy directory from $sourcePath to $destinationPath");
        }
    }

    /**
     * Export User Model
     * @return void
     */

    protected static function exportModel(): void
    {
        if (!is_dir($directory = app_path('Models'))) {
            mkdir($directory, 0755, true);
        }

        $filesystem = new Filesystem;

        collect($filesystem->allFiles(base_path('vendor/codecoz/aim-admin/src/stubs/app/Models')))
            ->each(function (SplFileInfo $file) use ($filesystem) {
                $filesystem->copy(
                    $file->getPathname(),
                    app_path('Models/' . Str::replaceLast('.stub', '.php', $file->getFilename()))
                );
            });
    }

    /**
     * Added Home as named route
     * @return void
     */
    protected static function addedHomeRoute(): void
    {
        // Read the content of web.php.stub
        $stubContent = file_get_contents(__DIR__ . '../../stubs/route/web.php.stub');

        // Get the path to web.php
        $webPath = base_path('routes/web.php');

        // Read the current content of web.php
        $webContent = file_get_contents($webPath);

        // Check if stub content is already in web.php
        if (!str_contains($webContent, "name('home')")) {
            // If not, append the stub content to web.php
            file_put_contents($webPath, $stubContent, FILE_APPEND);
        }
    }

    /**
     * Added home blade
     * @return void
     */
    protected static function addedHomeBlade(): void
    {
        copy(__DIR__ . '../../stubs/resources/views/home.blade.php', resource_path('views/home.blade.php'));
    }

    /**
     * Export the vite.config.js
     * @return void
     */
    protected static function exportVite(): void
    {
        copy(__DIR__ . '../../stubs/vite.config.js', base_path('vite.config.js'));
    }


    /**
     * Helper function to check for the import more reliably
     * @param $filePath
     * @param $lineToAdd
     * @return bool
     */
    protected static function hasImportBeenAdded($filePath, $lineToAdd): bool
    {
        $fileContent = file_get_contents($filePath);
        return str_contains($fileContent, $lineToAdd);
    }

}
