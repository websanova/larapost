<?php

namespace Websanova\Larapost\Console;

use Artisan;
use Illuminate\Console\Command;

class LarapostPublish extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'larapost:publish {--force} {--tag=}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Publish larapost files.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Websanova\\Larapost\\Providers\\LarapostServiceProvider',
            '--force' => $this->option('force', false),
            '--tag' => $this->option('tag')
        ]);

        echo Artisan::output();
    }
}