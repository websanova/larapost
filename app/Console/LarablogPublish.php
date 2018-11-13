<?php

namespace Websanova\Larablog\Console;

use Artisan;
use Illuminate\Console\Command;
use Websanova\Larablog\Parser\Type\Page;
use Websanova\Larablog\Parser\Type\Post;
use Websanova\Larablog\Parser\Field\Tags;
use Websanova\Larablog\Parser\Field\Series;

class LarablogPublish extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'larablog:publish {--tag=}';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Publish larablog files.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        Artisan::call('vendor:publish', [
            '--provider' => 'Websanova\\Larablog\\Providers\\LarablogServiceProvider',
            '--force' => true,
            '--tag' => $this->option('tag')
        ]);

        echo Artisan::output();
    }
}
