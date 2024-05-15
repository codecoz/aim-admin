<?php

namespace CodeCoz\AimAdmin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputArgument;
class AimAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aim-admin:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Aim Admin Make Command';

    // Constants for the types
    const TYPE_CONTROLLER = 'Controller';
    const TYPE_REPOSITORY = 'Repository';
    const TYPE_SERVICE = 'Service';
    const TYPE_Request = 'Request';
    const TYPE_ALL = 'All';
    const TYPE_ROUTE = 'Route';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $types = $this->choice(
            'What do you want to create ?',
            [self::TYPE_CONTROLLER, self::TYPE_REPOSITORY, self::TYPE_SERVICE, self::TYPE_Request, self::TYPE_ROUTE, self::TYPE_ALL],
            5,
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

                case self::TYPE_ROUTE:
                    $this->addToRoute($name);
                    break;
            }
        }

    }

    protected function createController($name): void
    {
        $this->call('aim-admin:make-controller', ['name' => $name]);
    }

    protected function createRepository($name): void
    {
        $this->call('aim-admin:make-repo-interface', ['name' => $name]);
        $this->call('aim-admin:make-repo', ['name' => $name]);
    }

    protected function createService($name): void
    {
        $this->call('aim-admin:make-service-interface', ['name' => $name]);
        $this->call('aim-admin:make-service', ['name' => $name]);
    }

    protected function createRequest($name): void
    {
        Artisan::call("make:request", ['name' => $name . 'Request']);
    }

    protected function addToRoute($name): void
    {
        $this->call('aim-admin:add-to-route', ['name' => $name]);
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
