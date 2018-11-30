<?php

namespace Websanova\Larablog\Parser\Field;

use DB;
use Websanova\Larablog\Models\Serie;

class Series
{
    public static function process($key, $val, $data, $type = 'series')
    {
        $slug = str_slug($val);

        $serie = Serie::where('slug', $slug)->where('type', $type)->first();

        if ( ! $serie) {
            $serie = Serie::create([
                'slug' => $slug,
                'title' => $val,
                'type' => $type
            ]);

            echo 'New Series: ' . $val . "\n";
        }

        $data['serie_id'] = $serie->id;

        return $data;
    }

    public function cleanup($type = 'series')
    {
        $prefix = config('larablog.table.prefix');

        DB::table($prefix . 'series')->update([
            'posts_count' => DB::raw("(SELECT COUNT(*) FROM {$prefix}posts WHERE {$prefix}posts.serie_id = {$prefix}series.id)")
        ]);

        Serie::where('type', $type)->where('posts_count', 0)->delete();
    }
}