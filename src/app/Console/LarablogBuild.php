<?php

namespace Websanova\Larablog\Console;

use Illuminate\Console\Command;
use Websanova\Larablog\Larablog;

// use Websanova\Larablog\Parser\Type\Doc;
// use Websanova\Larablog\Parser\Type\Page;
// use Websanova\Larablog\Parser\Type\Post;

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
    protected $description = 'Update docs and posts.';

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        $this->info('Larablog: posts');

        $lb = Larablog::post();

        $lb->build();

        // $lb->errors()->each();

        $lb->save();

        // $lb->inserts()->each();

        // $lb->updates()->each();

        // $lb->deletes()->each();





        $this->info('Larablog: docs');

        // Larablog::doc()->build();

        // Larablog::post()->build();

        // Larablog::post()->paginate();

        // $doc = Larablog::doc();

        // // $doc->parse();
        // $parser = $doc->build();

        // $parser->errors();

        // $doc->paginate();
        // $doc->find(0);


        // (new Larablog)->post()->build();



        // (new Post)->handle();

        // (new Page)->handle();

        // (new Doc)->handle();
    }
}