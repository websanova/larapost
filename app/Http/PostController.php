<?php

namespace Websanova\Larablog\Http;

use Redirect;
use Response;
use Websanova\Larablog\Larablog;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    public function index()
    {
		return view(config('larablog.theme'), [
            'view' => 'larablog::post.index',
            'posts' => Larablog::published()
        ]);
    }

    public function post()
    {
        $post = Larablog::post();

        if ( ! $post) {
            return self::notfound();
        }

        if ($post->type === 'redirect') {
            return Redirect::to($post->meta->redirect_to);
        }

        $post->increment('views_count');

        if ($post->type === 'page') {
            return self::page($post);
        }

        return view(config('larablog.theme'), [
            'view' => 'larablog::post.show',
            'post' => $post,
        ]);
    }

    public function page($post)
    {
        return view(config('larablog.theme'), [
            'view' => 'larablog::post.page',
            'type' => 'page',
            'post' => $post
        ]);
    }

    public function search()
    {
        return view(config('larablog.theme'), [
            'view' => 'larablog::post.search',
            'posts' => Larablog::search()
        ]);
    }

    public function notfound()
    {
        return view(config('larablog.theme'), [
            'view' => 'larablog::blog.404'
        ]);
    }
}