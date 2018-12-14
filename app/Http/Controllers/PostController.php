<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    public function index()
    {
		return view('larablog::themes.master', [
            'view' => larablog_view('post.index'),
            'posts' => Larablog::posts(),
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts()
        ]);
    }

    public function post()
    {
        $post = Larablog::post();

        if ( ! $post) {
            return self::notfound();
        }

        if ($post->type === 'redirect') {
            return Redirect::to($post->meta->redirect_to, 301);
        }

        $post->increment('views_count');

        if ($post->type === 'page') {
            return self::page($post);
        }

        return view('larablog::themes.master', [
            'view' => larablog_view('post.show'),
            'post' => $post,
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts(),
            'related' => Larablog::relatedPosts($post)
        ]);
    }

    public function page($post)
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('post.page'),
            'type' => 'page',
            'post' => $post,
            'series' => Larablog::allSeries(),
            'top' => Larablog::topPosts()
        ]);
    }

    public function search()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('post.search'),
            'posts' => Larablog::searchPosts(),
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