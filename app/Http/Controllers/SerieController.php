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
            'view' => lb_view('serie.index'),
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
        return view('larablog::themes.master', [
            'view' => lb_view('serie.show'),
            'serie' => $serie,
            'posts' => Larablog::publishedWhereSeries($serie),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function notfound()
    {
        return view('larablog::themes.master', [
            'view' => lb_view('error.404'),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }
}