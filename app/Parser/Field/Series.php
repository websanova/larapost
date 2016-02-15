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

        DB::table($prefix . '_series')->update([
            'posts_count' => DB::Raw("(SELECT COUNT(*) FROM {$prefix}_posts WHERE {$prefix}_posts.serie_id = {$prefix}_series.id)")
        ]);

        Serie::where('posts_count', 0)->delete();
    }
}