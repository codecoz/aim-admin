<?php

namespace CodeCoz\AimAdmin\Console;

use CodeCoz\AimAdmin\Admin;
use CodeCoz\AimAdmin\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class UpgradeAimAdminCommand extends Command
{
    protected $signature = 'aim-admin:upgrade';

    protected $description = 'Upgrade Aim Admin';

    /**
     * Handle the Full Installation
     * @return void
     */
    public function handle(): void
    {
        $this->info('Aim Admin is upgrading. Please wait....');
        self::exportLoadingGif();
        self::checkMissingOrUpdatedPackages();
        sleep(5);
        $this->info('Aim Admin upgrade complete !');
    }


    /**
     * Export the migrations
     * @return void
     */
    protected static function exportLoadingGif(): void
    {
        $filesystem = new Filesystem();
        $sourcePath = Admin::packagePath('resources/img/loader.gif');
        $destinationPath = public_path('img/loader.gif');

        // Check if the destination directory exists
        if (!$filesystem->exists(dirname($destinationPath))) {
            // Create the directory if it does not exist
            $filesystem->makeDirectory(dirname($destinationPath), 0755, true);
        }

        // Copy the loader.gif file to the destination directory
        if (!$filesystem->copy($sourcePath, $destinationPath)) {
            error_log("Failed to copy loading gif from $sourcePath to $destinationPath");
        }
    }

    /**
     * Check for missing or updated packages and update package.json
     * @return void
     */
    protected function checkMissingOrUpdatedPackages(): void
    {
        $this->info('Checking for missing or updated packages...');

        $packagesFile = json_decode(file_get_contents(base_path('package.json')), true);

        $requiredPackages = Helper::requiredPackages();

        $existingPackages = array_merge(
            $packagesFile['dependencies'] ?? [],
            $packagesFile['devDependencies'] ?? []
        );

        $missingPackages = [];
        $updatedPackages = [];

        foreach ($requiredPackages as $package => $version) {
            if (!isset($existingPackages[$package])) {
                $missingPackages[$package] = $version;
            } elseif ($existingPackages[$package] !== $version) {
                $updatedPackages[$package] = [
                    'current' => $existingPackages[$package],
                    'required' => $version,
                ];
            }
        }

        if (empty($missingPackages) && empty($updatedPackages)) {
            $this->info('All packages are up to date.');
        } else {
            if (!empty($missingPackages)) {
                $this->info('Missing packages:');
                foreach ($missingPackages as $package => $version) {
                    $this->line(" - $package: $version");
                }
            }

            if (!empty($updatedPackages)) {
                $this->info('Packages to be updated:');
                foreach ($updatedPackages as $package => $versions) {
                    $this->line(" - $package: current version {$versions['current']}, required version {$versions['required']}");
                }
            }
            // Ask for user permission before updating package.json
            if ($this->confirm('Do you want to update package.json with the missing and updated packages?')) {
                $this->info('Up gradation is on progress....');
                $this->upgradePackageJson($missingPackages, $updatedPackages);
            } else {
                $this->info('package.json was not updated.');
            }
        }
    }

    /**
     * Update package.json with missing and updated packages
     * @param array $missingPackages
     * @param array $updatedPackages
     * @return void
     */
    protected function upgradePackageJson(array $missingPackages, array $updatedPackages): void
    {
        $packagesFile = json_decode(file_get_contents(base_path('package.json')), true);

        // Combine all the packages to be updated
        $packagesToUpdate = array_merge(
            $missingPackages,
            array_map(function ($versions) {
                return $versions['required'];
            }, $updatedPackages)
        );

        // Update devDependencies with the packages to be updated
        $packagesFile['devDependencies'] = array_merge(
            $packagesFile['devDependencies'] ?? [],
            $packagesToUpdate
        );

        ksort($packagesFile['devDependencies']);

        file_put_contents(
            base_path('package.json'),
            json_encode($packagesFile, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );

        $this->info('package.json has been updated with missing and updated packages.');
    }
}
