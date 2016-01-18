<?php

namespace Websanova\Larablog\Parser\Field;

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
}