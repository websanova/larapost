<?php

namespace Websanova\Larablog\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Websanova\Larablog\Models\Blog;
use Illuminate\Support\Facades\File;
use Websanova\Larablog\Parser\Parser;

class LarablogReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larablog:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs through blog folder and generates files.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = base_path(config('larablog.folder_path'));

        if (file_exists($path)) {
            $files = File::files($path);

            Blog::truncate();

            foreach ($files as $file) {
                $fields = Parser::parse($file);

                $data = Parser::process($fields);

                echo 'Post: ' . $data['slug'] . "\n";

                $post = Blog::create($data);

                Parser::handle($fields, $post);
            }
        }
        else {
            echo "\nThe \"" . $path . "\" folder does not exist.\n\n";
        }
    }
}
