<?php

namespace CodeCoz\AimAdmin\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class AimCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aim:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aim Make Command';

    // Constants for the types
    const TYPE_CONTROLLER = 'Controller';
    const TYPE_REPOSITORY = 'Repository';
    const TYPE_SERVICE = 'Service';
    const TYPE_Request = 'Request';
    const TYPE_ALL = 'All';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $types = $this->choice(
            'What do you want to create ?',
            [self::TYPE_CONTROLLER, self::TYPE_REPOSITORY, self::TYPE_SERVICE, self::TYPE_Request, self::TYPE_ALL],
            4,
            $maxAttempts = null,
            $allowMultipleSelections = true
        );

        $name = $this->ask("What is the name ?", 'Product');

        foreach ($types as $type) {
            switch ($type) {
                case self::TYPE_CONTROLLER:
                    $this->createController($name);
                    break;

                case self::TYPE_REPOSITORY:
                    $this->createRepository($name);
                    break;

                case self::TYPE_SERVICE:
                    $this->createService($name);
                    break;

                case self::TYPE_Request:
                    $this->createRequest($name);
                    break;

                case self::TYPE_ALL:
                    $this->createAll($name);
                    break;
            }
        }

    }

    protected function createController($name): void
    {
        $this->call('aim:make-controller', ['name' => $name]);
    }

    protected function createRepository($name): void
    {
        $this->call('aim:make-repo-interface', ['name' => $name]);
        $this->call('aim:make-repo', ['name' => $name]);
    }

    protected function createService($name): void
    {
        $this->call('aim:make-service-interface', ['name' => $name]);
        $this->call('aim:make-service', ['name' => $name]);
    }

    protected function createRequest($name): void
    {
        $this->call('aim:make-request', ['name' => $name]);
    }

    protected function createAll($name)
    {
        $this->createController($name);
        $this->createRepository($name);
        $this->createService($name);
        $this->createRequest($name);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the model to which the repository will be generated'],
        ];
    }
}
