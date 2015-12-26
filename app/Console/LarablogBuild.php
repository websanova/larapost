<?php

namespace Websanova\Larablog\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Websanova\Larablog\Models\Blog;
use Illuminate\Support\Facades\File;
use Websanova\Larablog\Parser\Parser;

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
        $path = base_path(config('larablog.folder_path'));

        if (file_exists($path)) {
            $files = File::files($path);

            foreach ($files as $file) {
                $fields = Parser::parse($file);

                $data = Parser::process($fields);

                $post = Blog::where('slug', $data['slug'])->first();

                if ($post) {
                    $post->fill($data);

                    if ($post->isDirty()) {
                        $post->save();
                        echo 'Update Post: ' . $data['slug'] . "\n";
                    }
                }
                else {
                    $post = Blog::create($data);
                    echo 'New Post: ' . $data['slug'] . "\n";
                }

                Parser::handle($fields, $post);
            }
        }
        else {
            echo "\nThe \"" . $path . "\" folder does not exist.\n\n";
        }
    }
}
