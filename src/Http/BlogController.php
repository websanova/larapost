<?php

namespace Websanova\Larablog\Http;

use Redirect;
use Websanova\Larablog\Larablog;
use Illuminate\Routing\Controller as BaseController;

class BlogController extends BaseController
{
    public function index()
    {
		return view('larablog::blog.index', [
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

        return view('larablog::blog.post', [
            'post' => $post
        ]);
    }

    public function search()
    {
        return view('larablog::blog.search', [
            'posts' => Larablog::search()
        ]);
    }

    public function feed()
    {

    }

    public function sitemap()
    {

    }

    public function notfound()
    {
        return view('larablog::blog.404');
    }
}