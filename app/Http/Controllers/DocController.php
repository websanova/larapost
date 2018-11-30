<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Post;
use Websanova\Larablog\Models\Serie;
use Illuminate\Routing\Controller as BaseController;

class DocController extends BaseController
{
    public function index()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('doc.index'),
            'docs' => Larablog::docs(),
            'search' => false
        ]);
    }

    public function show($slug)
    {
        $doc = Serie::where('slug', $slug)->where('type', 'docs')->first();

        if (!$doc) {
            return self::notfound();
        }

        $post = Post::where('serie_id', $doc->id)->orderBy('order', 'asc')->first();

        if (!$post) {
            return self::notfound();
        }

        return redirect('/docs/' . $doc->slug . '/' . $post->identifier);
    }

    public function chapter($doc, $slug)
    {
        $doc = Serie::where('slug', $doc)->where('type', 'docs')->first();

        if ( ! $doc) {
            return self::notfound();
        }

        $chapters = Larablog::chapters($doc);

        $post = Post::where('identifier', $slug)->first();

        if (!$post) {
            return self::notfound();
        }

        return view('larablog::themes.master', [
            'view' => larablog_view('doc.chapter'),
            'search' => false,
            'doc' => $doc,
            'chapters' => $chapters,
            'post' => $post
        ]);
    }

    public function notfound()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('error.404'),
            'docs' => Larablog::docs(),
        ]);
    }
}