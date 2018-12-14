<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Tag;
use Illuminate\Routing\Controller as BaseController;

class TagController extends BaseController
{
    public function index()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('tag.index'),
            'tags' => Larablog::allTags(),
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts()
        ]);
    }

    public function show()
    {
        $tag = Larablog::tag();

        if ( ! $tag) {
            return self::notfound();
        }
        
        return view('larablog::themes.master', [
            'view' => larablog_view('tag.show'),
            'tag' => $tag,
            'posts' => Larablog::tagPosts($tag),
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts()
        ]);
    }

    public function notfound()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('error.404'),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }
}