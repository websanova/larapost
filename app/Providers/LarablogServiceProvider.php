<?php

namespace Websanova\Larablog\Providers;

use Illuminate\Support\ServiceProvider;

class LarablogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('larablog', function() {
            return new Larablog;
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/larablog.php', 'larablog'
        );

        $this->commands([
            'Websanova\Larablog\Commands\LarablogReset'
        ]);
    }

    public function boot()
    {
        // $this->publishes([
        //     __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        // ], 'migrations');

        // $this->publishes([
        //     __DIR__ . '/views' => base_path('resources/views/vendor/websanova-demo')
        // ], 'views');

        // $this->publishes([
        //     __DIR__ . '/config' => config_path('larablog')
        // ], 'config');
        
        require __DIR__ . '/../Http/routes.php';

	    $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'larablog');
    }
}
