<?php

namespace CodeCoz\AimAdmin\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
class MakeAimRepository extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'aim-admin:make-repo';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'aim:make-repo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Aim Admin Repo';


    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/aim-admin.repository.stub');
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        // Extract model name and namespace from input name
        $parts = explode('\\', trim($this->argument('name')));
        $model = Str::singular(end($parts));
        $namespace = implode('\\', array_slice($parts, 0, -1));

        // Construct repository namespace
        $repoContractsNamespace = "App\Contracts\Repositories";
        if (!empty($namespace)) {
            $repoContractsNamespace .= "\\" . $namespace;
        }

        // Replace placeholders and return stub
        return str_replace(
            [
                "{{ tableModel }}",
                "{{ repoContractsNamespace }}"
            ],
            [
                $model,
                $repoContractsNamespace
            ],
            parent::buildClass($name)
        );
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
        return $rootNamespace . '\Repositories';
    }


    protected function getNameInput(): string
    {
        $name = trim($this->argument('name'));

        // Append 'Controller' to the name if it doesn't already end with it
        if (!str_ends_with($name, 'Repository')) {
            $name .= 'Repository';
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
