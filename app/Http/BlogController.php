<?php

namespace Websanova\Larablog\Http;

use Redirect;
use Response;
use Websanova\Larablog\Larablog;
use Illuminate\Routing\Controller as BaseController;

class BlogController extends BaseController
{
    public function index()
    {
		return view(config('larablog.theme'), [
            'view' => 'larablog::blog.index',
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

        if ($post->type === 'page') {
            return self::page($post);
        }

        return view(config('larablog.theme'), [
            'view' => 'larablog::blog.post',
            'post' => $post,
        ]);
    }

    public function page($post)
    {
        return view(config('larablog.theme'), [
            'view' => 'larablog::blog.page',
            'type' => 'page',
            'post' => $post
        ]);
    }

    public function search()
    {
        return view(config('larablog.theme'), [
            'view' => 'larablog::blog.search',
            'posts' => Larablog::search()
        ]);
    }

    public function feed()
    {
        $content = view('larablog::blog.feed', [
            'last' => Larablog::last(),
            'posts' => Larablog::all()
        ]);

        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    public function sitemap()
    {
        $content = view('larablog::blog.sitemap', [
            'last' => Larablog::last(),
            'posts' => Larablog::all()
        ]);

        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    public function opensearch()
    {
        $content = view('larablog::blog.opensearch');

        return Response::make($content, '200')->header('Content-Type', 'text/xml');
    }

    public function notfound()
    {
        return view(config('larablog.theme'), [
            'view' => 'larablog::blog.404'
        ]);
    }
}