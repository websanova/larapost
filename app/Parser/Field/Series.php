<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Models\Series as SeriesModel;

class Series
{
    public static function process($key, $val, $data)
    {
        $slug = str_slug($val);

        $series = SeriesModel::where('slug', $slug)->first();

        if ( ! $series) {
            $series = SeriesModel::create([
                'slug' => $slug,
                'title' => $val
            ]);

            echo 'New Series: ' . $val . "\n";
        }

        $data['series_id'] = $series->id;

        return $data;
    }
}