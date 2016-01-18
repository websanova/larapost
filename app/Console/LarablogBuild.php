<?php

namespace Websanova\Larablog\Console;

//use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Websanova\Larablog\Models\Tag;
use Websanova\Larablog\Models\Series;
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
        $path = base_path(config('larablog.app.path'));

        (new Post($path))->handle();
        (new Page($path))->handle();

        $prefix = config('larablog.table.prefix');

        // TODO: Delete old redirects somehow.

        // TODO: convert to eloquent?
        DB::table($prefix . '_tags')->update([
            'posts_count' => DB::Raw("(SELECT COUNT(*) FROM {$prefix}_post_tag WHERE {$prefix}_post_tag.tag_id = {$prefix}_tags.id)")
        ]);

        DB::table($prefix . '_series')->update([
            'posts_count' => DB::Raw("(SELECT COUNT(*) FROM {$prefix}_posts WHERE {$prefix}_posts.series_id = {$prefix}_series.id)")
        ]);

        Tag::where('posts_count', 0)->delete();
        Series::where('posts_count', 0)->delete();
    }
}
