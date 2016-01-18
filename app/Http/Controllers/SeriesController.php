<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Series;
use Illuminate\Routing\Controller as BaseController;

class SeriesController extends BaseController
{
    public function index()
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::series.index',
            'series' => Larablog::series(),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function show($slug)
    {
        $series = Series::where('slug', $slug)->first();

        if ( ! $series) {
            return self::notfound();
        }
        
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::series.show',
            'series' => $series,
            'posts' => Larablog::publishedWhereSeries($series),
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