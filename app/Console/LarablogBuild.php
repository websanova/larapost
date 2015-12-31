<?php

namespace Websanova\Larablog\Console;

use DB;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Websanova\Larablog\Models\Tag;
use Websanova\Larablog\Models\Post;
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

                $post = Post::where('slug', $data['slug'])->first();

                if ($post) {
                    $post->fill($data);

                    if ($post->isDirty()) {
                        $post->save();
                        echo 'Update Post: ' . $data['slug'] . "\n";
                    }
                }
                else {
                    $post = Post::create($data);
                    echo 'New Post: ' . $data['slug'] . "\n";
                }

                Parser::handle($fields, $post);
            }

            // Find deletes

            // Reset tag counts.
            DB::statement("UPDATE blog_tags AS bt SET posts_count = (SELECT COUNT(*) FROM blog_post_tag AS bpt WHERE bpt.tag_id = bt.id)");

            Tag::where('posts_count', 0)->delete();
        }
        else {
            echo "\nThe \"" . $path . "\" folder does not exist.\n\n";
        }
    }
}
