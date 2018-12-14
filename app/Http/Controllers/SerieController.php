<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Serie;
use Illuminate\Routing\Controller as BaseController;

class SerieController extends BaseController
{
    public function index()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('serie.index'),
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts()
        ]);
    }

    public function show($slug)
    {
        $serie = Larablog::series();

        if ( ! $serie) {
            return self::notfound();
        }

        return view('larablog::themes.master', [
            'view' => larablog_view('serie.show'),
            'serie' => $serie,
            'posts' => Larablog::seriesPosts($serie),
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts()
        ]);
    }

    public function notfound()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('error.404'),
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts()
        ]);
    }
}