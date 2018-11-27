<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Doc;
use Illuminate\Routing\Controller as BaseController;

class DocController extends BaseController
{
    public function index()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('doc.index'),
            'docs' => Larablog::docs(),
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
            'view' => larablog_view('serie.show'),
            'serie' => $serie,
            'posts' => Larablog::publishedWhereSeries($serie),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function section($slug)
    {
        $serie = Serie::where('slug', $slug)->first();

        if ( ! $serie) {
            return self::notfound();
        }
        return view('larablog::themes.master', [
            'view' => larablog_view('serie.show'),
            'serie' => $serie,
            'posts' => Larablog::publishedWhereSeries($serie),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function notfound()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('error.404'),
            'docs' => Larablog::docs(),
            'top' => Larablog::top()
        ]);
    }
}