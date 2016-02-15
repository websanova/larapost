<?php

namespace Websanova\Larablog\Console;

//use Carbon\Carbon;
use Illuminate\Console\Command;
use Websanova\Larablog\Parser\Type\Page;
use Websanova\Larablog\Parser\Type\Post;
use Websanova\Larablog\Parser\Field\Tags;
use Websanova\Larablog\Parser\Field\Series;

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
        $path = base_path(config('larablog.app.path'));

        (new Post($path))->handle();
        (new Page($path))->handle();

        // TODO: Where to register these cleanup functions?
        (new Tags)->cleanup();
        (new Series)->cleanup();
    }
}
