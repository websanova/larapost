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
            'series' => Larablog::series(),
            'top' => Larablog::top()
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
            'series' => Larablog::series(),
            'top' => Larablog::top(),
            'related' => [
                   (object)[
                    'url' => 'plugins/rgbhex',
                    'full_title' => 'JavaScript RGB / HEX Converter',
                    'img' => '/img/intelligent-javascript-rgb-hex-converter.png'
                ], (object)[
                    'url' => '/plugins/mousestop',
                    'full_title' => 'JavaScript mousestop() Event Plugin',
                    'img' => '/img/jquery-mouse-stop-event-plugin.png'
                ], (object)[
                    'url' => '/plugins/wboiler',
                    'full_title' => 'jQuery Plugin Development Boilerplate',
                    'img' => '/img/jquery-plugin-development-boilerplate.png',
                ], (object)[
                    'url' => '/blog/jquery/the-ultimate-guide-to-writing-jquery-plugins',
                    'full_title' => 'The Ultimate Guide to Writing jQuery Plugins',
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
            'post' => $post,
            'series' => Larablog::series(),
            'top' => Larablog::top()
        ]);
    }

    public function search()
    {
        return view(config('larablog.app.theme'), [
            'view' => 'larablog::post.search',
            'posts' => Larablog::search(),
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