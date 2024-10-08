<?php

namespace CodeCoz\AimAdmin\Tests\Traits;


use CodeCoz\AimAdmin\Tests\TestView;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;

trait InteractsWithViews
{
    /**
     * Create a new TestView from the given view.
     *
     * @param string $view
     * @return TestView
     * @return TestView
     */
    protected function view(string $view, array $data = [])
    {
        return new TestView(view($view, $data));
    }

    /**
     * Render the contents of the given Blade template string.
     *
     * @param string $template
     * @return TestView
     */
    protected function blade(string $template, array $data = [])
    {
        $tempDirectory = sys_get_temp_dir();

        if (!in_array($tempDirectory, ViewFacade::getFinder()->getPaths())) {
            ViewFacade::addLocation(sys_get_temp_dir());
        }

        $tempFile = tempnam($tempDirectory, 'laravel-blade') . '.blade.php';

        file_put_contents($tempFile, $template);

        return new TestView(view(Str::before(basename($tempFile), '.blade.php'), $data));
    }

    /**
     * Render the given view component.
     *
     * @param string $componentClass
     * @param array $data
     * @return TestView
     * @throws BindingResolutionException
     */
    protected function component(string $componentClass, array $data = [])
    {
        $component = $this->app->make($componentClass, $data);

        $view = $component->resolveView();

        return $view instanceof View
            ? new TestView($view->with($component->data()))
            : new TestView(view($view, $component->data()));
    }

    /**
     * Populate the shared view error bag with the given errors.
     *
     * @param array $errors
     * @param string $key
     * @return void
     */
    protected function withViewErrors(array $errors, $key = 'default')
    {
        ViewFacade::share('errors', (new ViewErrorBag())->put($key, new MessageBag($errors)));
    }
}
