<?php

namespace Websanova\Larapost\Providers;

use Illuminate\Support\ServiceProvider;
use Websanova\Larapost\Larapost;

class LarapostServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('larapost', function() {
            return new Larapost;
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/larapost.php', 'larapost'
        );

        $this->commands([
            'Websanova\Larapost\Console\LarapostBuild',
            'Websanova\Larapost\Console\LarapostPublish'
        ]);
    }

    public function boot()
    {
        $this->publishes([
             __DIR__ . '/../../database/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');

        // $this->publishes([
        //     __DIR__ . '/../../resources/views' => base_path('resources/views/vendor/larapost')
        // ], 'views');

        $this->publishes([
            __DIR__ . '/../../config' => config_path()
        ], 'config');

        // $this->publishes([
        //     __DIR__ . '/../../resources/assets' => public_path()
        // ], 'assets');

        // require __DIR__ . '/../Support/helpers.php';

        // require __DIR__ . '/../Http/routes.php';

        // $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'larapost');
    }
}
