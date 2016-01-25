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
            'view' => lb_view('tag.index'),
            'tags' => Larablog::tags(),
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->first();

        if ( ! $tag) {
            return self::notfound();
        }
        
        return view('larablog::themes.master', [
            'view' => lb_view('tag.show'),
            'tag' => $tag,
            'posts' => Larablog::publishedWhereTag($tag),
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