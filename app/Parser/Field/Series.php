<?php

namespace Websanova\Larablog\Parser\Field;

use Illuminate\Support\Facades\DB;
use Websanova\Larablog\Models\Serie;

class Series
{
    public static function process($key, $val, $data)
    {
        $slug = str_slug($val);

        $serie = Serie::where('slug', $slug)->first();

        if ( ! $serie) {
            $serie = Serie::create([
                'slug' => $slug,
                'title' => $val
            ]);

            echo 'New Series: ' . $val . "\n";
        }

        $data['serie_id'] = $serie->id;

        return $data;
    }

    public function cleanup()
    {
        $prefix = config('larablog.table.prefix');

        DB::table($prefix . 'series')->update([
            'posts_count' => DB::raw("(SELECT COUNT(*) FROM {$prefix}posts WHERE {$prefix}posts.serie_id = {$prefix}series.id)")
        ]);

        Serie::where('posts_count', 0)->delete();
    }
}