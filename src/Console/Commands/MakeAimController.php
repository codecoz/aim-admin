<?php

namespace CodeCoz\AimAdmin\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeAimController extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'aim-admin:make-controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'aim:make-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Aim Admin Controller';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/aim-admin.controller.stub');
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
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $stub = parent::buildClass($name);

        $fullName = Str::singular(class_basename($name));

        $cleanedName = str_replace("Controller", "", $fullName);

        $camelModel = Str::camel($cleanedName);

        // Replace placeholders in one go
        return str_replace(
            ["{{ camelName }}", "{{ cleanName }}"],
            [$camelModel, $cleanedName],
            $stub
        );
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Http\Controllers';
    }

    protected function getNameInput(): string
    {
        $name = trim($this->argument('name'));

        // Append 'Controller' to the name if it doesn't already end with it
        if (!str_ends_with($name, 'Controller')) {
            $name .= 'Controller';
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
