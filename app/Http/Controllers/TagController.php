<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Tag;
use Illuminate\Routing\Controller as BaseController;

class TagController extends BaseController
{
    public function index()
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::tag.index',
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
        
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::tag.show',
            'tag' => $tag,
            'posts' => Larablog::publishedWhereTag($tag),
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