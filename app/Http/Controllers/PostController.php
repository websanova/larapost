<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Controller as BaseController;

class PostController extends BaseController
{
    public function index()
    {
		return view(config('larablog.app.theme'), [
            'view' => 'larablog::post.index',
            'posts' => Larablog::published(),
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

        return view(config('larablog.app.theme'), [
            'view' => 'larablog::post.show',
            'post' => $post,
            'related' => [
                   (object)[
                    'url' => 'plugins/rgbhex',
                    'title' => 'JavaScript RGB / HEX Converter',
                    'img' => '/img/intelligent-javascript-rgb-hex-converter.png'
                ], (object)[
                    'url' => '/plugins/mousestop',
                    'title' => 'JavaScript mousestop() Event Plugin',
                    'img' => '/img/jquery-mouse-stop-event-plugin.png'
                ], (object)[
                    'url' => '/plugins/wboiler',
                    'title' => 'jQuery Plugin Development Boilerplate',
                    'img' => '/img/jquery-plugin-development-boilerplate.png',
                ], (object)[
                    'url' => '/blog/jquery/the-ultimate-guide-to-writing-jquery-plugins',
                    'title' => 'The Ultimate Guide to Writing jQuery Plugins',
                    'img' => '/img/ultimate-guide-to-writing-jquery-plugins.png',
                ]
            ]
        ]);
    }

    public function page($post)
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::post.page',
            'type' => 'page',
            'post' => $post
        ]);
    }

    public function search()
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::post.search',
            'posts' => Larablog::search()
        ]);
    }

    public function notfound()
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::blog.404'
        ]);
    }
}