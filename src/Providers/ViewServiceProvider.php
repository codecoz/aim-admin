<?php

namespace CodeCoz\AimAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Macro for injecting JS
        View::macro('injectTop', function ($files) {
            $content = '';
            foreach ((array)$files as $file) {
                if (view()->exists($file)) {
                    $content .= view($file)->render();
                } else {
                    Log::warning("JS file not found: {$file}"); // Log if file is missing
                }
            }
            return $this->with('injectedTop', $content);
        });

        // Macro for injecting CSS
        View::macro('injectBottom', function ($files) {
            $content = '';
            foreach ((array)$files as $file) {
                if (view()->exists($file)) {
                    $content .= view($file)->render();
                } else {
                    Log::warning("CSS file not found: {$file}"); // Log if file is missing
                }
            }
            return $this->with('injectedBottom', $content);
        });
    }
}
