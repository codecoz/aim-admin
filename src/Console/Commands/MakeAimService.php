<?php

namespace CodeCoz\AimAdmin\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeAimService extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'aim-admin:make-service';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'aim:make-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Aim Admin Service';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/aim-admin.service.stub');
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        // Extract model and namespace from input name
        $parts = explode('\\', trim($this->argument('name')));
        $namespace = implode('\\', array_slice($parts, 0, -1));
        $model = Str::studly(Str::replace("Service", "", end($parts)));

        // Repository namespace
        $repoNamespace = "App\Repositories";
        if (!empty($namespace)) {
            $repoNamespace .= "\\" . $namespace;
        }

        // Construct repository namespace
        $repoConstructNamespace = "App\Contracts\Repositories";
        if (!empty($namespace)) {
            $repoConstructNamespace .= "\\" . $namespace;
        }

        $serviceContractsNamespace = "App\Contracts\Services";
        if (!empty($namespace)) {
            $serviceContractsNamespace .= "\\" . $namespace;
        }

        // Combine placeholders and values for replacement
        $replacements = [
            "{{ camelName }}" => Str::camel($model),
            "{{ tableModel }}" => $model,
            "{{ repoNamespace }}" => $repoNamespace,
            "{{ repoConstructNamespace }}" => $repoConstructNamespace,
            "{{ serviceContractsNamespace }}" => $serviceContractsNamespace,
        ];

        // Replace placeholders in stub and return
        return str_replace(array_keys($replacements), array_values($replacements), parent::buildClass($name));
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     */
    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Services';
    }

    protected function getNameInput(): string
    {
        $name = trim($this->argument('name'));

        // Append 'Controller' to the name if it doesn't already end with it
        if (!str_ends_with($name, 'Service')) {
            $name .= 'Service';
        }

        return $name;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the class already exists'],
        ];
    }
}
