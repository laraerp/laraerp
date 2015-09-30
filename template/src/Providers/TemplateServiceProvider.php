<?php

namespace Laraerp\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;

class TemplateServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        /*
         * Publish public
         */
        $this->publishes([__DIR__ . '/../../public' => public_path('vendor/laraerp/template')]);

        /*
         * Add resource/views
         */
        $this->app->bind('view.finder', function ($app) {
            $paths = $app['config']['view.paths'];

            $paths[] = __DIR__ . '/../../resources/views';

            return new FileViewFinder($app['files'], $paths);
        });
    }

}
