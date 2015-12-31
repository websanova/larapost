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

            DB::table(config('larablog.table_post_tag'))->truncate();
            DB::table(config('larablog.table_tags'))->truncate();
            DB::table(config('larablog.table_posts'))->truncate();

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

            // TODO: convert to eloquent?
            DB::table(config('larablog.table_tags'))->update([
                'posts_count' => DB::Raw("(SELECT COUNT(*) FROM blog_post_tag WHERE blog_post_tag.tag_id = blog_tags.id)")
            ]);
        }
        else {
            echo "\nThe \"" . $path . "\" folder does not exist.\n\n";
        }
    }
}
