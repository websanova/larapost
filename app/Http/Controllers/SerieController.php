<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Serie;
use Illuminate\Routing\Controller as BaseController;

class SerieController extends BaseController
{
    public function index()
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::serie.index',
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function show($slug)
    {
        $serie = Serie::where('slug', $slug)->first();

        if ( ! $serie) {
            return self::notfound();
        }
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::serie.show',
            'serie' => $serie,
            'posts' => Larablog::publishedWhereSeries($serie),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function notfound()
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::blog.404',
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }
}