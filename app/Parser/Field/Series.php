<?php

namespace Websanova\Larablog\Parser\Field;

use DB;
use Websanova\Larablog\Models\Serie;

class Series
{
    public static function process($key, $data, $fields)
    {
        $slug = str_slug($fields[$key]);

        $serie = Serie::where('slug', $slug)->where('type', $key)->first();

        if ( ! $serie) {
            $serie = Serie::create([
                'slug' => $slug,
                'title' => $fields[$key],
                'type' => $key
            ]);

            echo 'New Series: ' . $fields[$key] . "\n";
        }

        $data['serie_id'] = $serie->id;

        return $data;
    }

    public function cleanup($key = 'series')
    {
        $prefix = config('larablog.tables.prefix');

        DB::table($prefix . 'series')->update([
            'posts_count' => DB::raw("(SELECT COUNT(*) FROM {$prefix}posts WHERE {$prefix}posts.serie_id = {$prefix}series.id)")
        ]);

        Serie::where('type', $key)->where('posts_count', 0)->delete();
    }
}