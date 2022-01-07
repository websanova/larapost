<?php

namespace Websanova\Larablog\Console;

use Illuminate\Console\Command;
use Websanova\Larablog\Parser\Type\Doc;
use Websanova\Larablog\Parser\Type\Page;
use Websanova\Larablog\Parser\Type\Post;

class LarablogBuild extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'larablog:build';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Add and update blog posts.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        (new Post)->handle();

        (new Page)->handle();

        (new Doc)->handle();
    }
}