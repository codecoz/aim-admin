<?php

namespace CodeCoz\AimAdmin\Providers;

use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     * @throws Exception
     */
    public function register()
    {
        tap(new Filesystem(), function ($filesystem) {
            if ($filesystem->isDirectory(app_path('Contracts/Services'))) {
                $this->autoBindInterfaces(app_path('Contracts/Services'), app_path('Services'));
            }
            if ($filesystem->isDirectory(app_path('Contracts/Repositories'))) {
                $this->autoBindInterfaces(app_path('Contracts/Repositories'), app_path('Repositories'));
            }
        });
    }


    /**
     * @param $contractsPath
     * @param $implementationPath
     * @return void
     */
    private function autoBindInterfaces($contractsPath, $implementationPath): void
    {
        $files = app(Filesystem::class)->allFiles($contractsPath);

        foreach ($files as $file) {

            $contractNamespace = $this->extractNamespace($file->getPathname());

            $contractClass = $contractNamespace . "\\" . $file->getFilenameWithoutExtension();

            // Ensure class existence and interface nature
            if (!interface_exists($contractClass)) {
                continue; // Skip if not a valid interface
            }

            $implementationClass = $this->getImplementationClass($contractClass);

            if (class_exists($implementationClass)) {
                $this->app->bind($contractClass, $implementationClass);
            }

        }
    }

    private function getImplementationClass($contractClass): array|string|null
    {
        // Remove the 'Contracts' namespace segment and 'Interface' suffix
        $implementationClass = str_replace('Contracts\\', '', $contractClass);
        return preg_replace('/Interface$/', '', $implementationClass);
    }

    private function extractNamespace(string $filePath): string
    {
        // Optimized namespace extraction using a single regular expression
        $contents = file_get_contents($filePath);
        preg_match('/namespace\s+(.*);/', $contents, $matches);
        return trim($matches[1]) ?? '';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
