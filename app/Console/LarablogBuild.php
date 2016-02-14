<?php

namespace Websanova\Larablog\Console;

//use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Websanova\Larablog\Models\Tag;
use Websanova\Larablog\Models\Serie;
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

        // Clean out any old pivot data.
        DB::statement("DELETE {$prefix}_post_tag FROM {$prefix}_post_tag LEFT JOIN {$prefix}_posts ON {$prefix}_post_tag.post_id = {$prefix}_posts.id WHERE NOT({$prefix}_post_tag.post_id = {$prefix}_posts.id AND {$prefix}_posts.status = 'active' AND {$prefix}_posts.type='post')");

        // TODO: convert to eloquent?
        DB::table($prefix . '_tags')->update([
            'posts_count' => DB::Raw("(SELECT COUNT(*) FROM {$prefix}_post_tag WHERE {$prefix}_post_tag.tag_id = {$prefix}_tags.id)")
        ]);

        DB::table($prefix . '_series')->update([
            'posts_count' => DB::Raw("(SELECT COUNT(*) FROM {$prefix}_posts WHERE {$prefix}_posts.serie_id = {$prefix}_series.id)")
        ]);

        Tag::where('posts_count', 0)->delete();
        Serie::where('posts_count', 0)->delete();
    }
}
