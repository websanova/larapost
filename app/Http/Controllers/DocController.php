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
            'docs' => Larablog::allDocs(),
            'search' => false
        ]);
    }

    public function show()
    {
        $doc = Larablog::doc();

        if (!$doc) {
            return self::notfound();
        }

        $post = Larablog::firstPost($doc);

        if (!$post) {
            return self::notfound();
        }

        return redirect($post->permalink);
    }

    public function chapter()
    {
        $doc = Larablog::doc();

        if ( ! $doc) {
            return self::notfound();
        }

        $post = Larablog::post();

        if (!$post) {
            return self::notfound();
        }

        return view('larablog::themes.master', [
            'view' => larablog_view('doc.chapter'),
            'search' => false,
            'doc' => $doc,
            'chapters' => $doc->chapters,
            'post' => $post
        ]);
    }

    public function notfound()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('error.404'),
            'docs' => Larablog::allDocs(),
        ]);
    }
}