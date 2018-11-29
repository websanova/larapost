<?php

namespace Websanova\Larablog\Http\Controllers;

use Websanova\Larablog\Larablog;
use Websanova\Larablog\Models\Doc;
use Illuminate\Routing\Controller as BaseController;

class DocController extends BaseController
{
    public function index()
    {
        return view('larablog::themes.master', [
            'view' => larablog_view('doc.index'),
            'docs' => Larablog::docs(),
            'search' => false
            // 'top' => Larablog::top()
        ]);
    }

    public function show($doc)
    {
        if ($doc !== 'vue-upload') {
            return self::notfound();
        }

        return redirect('/docs/vue-upload/chapter-one');
    }

    public function chapter($doc, $slug)
    {
        if ($doc !== 'vue-upload') {
            return self::notfound();
        }

        if (!in_array($slug, ['chapter-one', 'chapter-two', 'methods', 'options'])) {
            return self::notfound();
        }

        $doc = (object)[
            'slug' => '/docs/vue-upload',
            'url' => route('docs') . '/vue-upload',
            'title' => 'Vue Upload'
        ];

        // $chapter = (object)[
        //     'title' => 'Chapter One'
        // ];

        $chapters = Larablog::chapters($doc);

        $post = (object)[
            'identifier' => $slug,
            'title' => $slug,
            'type' => 'chapter',
            'body' => \Websanova\Larablog\Markdown\Markdown::extra(file_get_contents(resource_path('larablog/docs/vue-upload/' . $slug . '.md')))
        ];

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
            // 'top' => Larablog::top()
        ]);
    }
}