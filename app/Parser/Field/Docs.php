<?php

namespace Websanova\Larablog\Parser\Field;

use DB;
use Websanova\Larablog\Models\Doc;

class Docs
{
    public static function process($key, $val, $data)
    {
        $slug = str_slug($val);

        $doc = Doc::where('slug', $slug)->first();

        if ( ! $doc) {
            $doc = Doc::create([
                'slug' => $slug,
                'title' => $val
            ]);

            echo 'New Doc: ' . $val . "\n";
        }

        $data['doc_id'] = $doc->id;

        return $data;
    }

    public function cleanup()
    {
        $prefix = config('larablog.table.prefix');

        DB::table($prefix . 'docs')->update([
            'posts_count' => DB::raw("(SELECT COUNT(*) FROM {$prefix}posts WHERE {$prefix}posts.doc_id = {$prefix}docs.id)")
        ]);

        Doc::where('posts_count', 0)->delete();
    }
}