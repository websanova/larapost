<?php

return [

    'parser' => \Websanova\Larablog\Parsers\LarablogParser::class,

    'fields' => [
        \Websanova\Larablog\Parsers\Fields\Doc::class,
        \Websanova\Larablog\Parsers\Fields\Description::class,
        \Websanova\Larablog\Parsers\Fields\Keywords::class,
        \Websanova\Larablog\Parsers\Fields\Order::class,
        \Websanova\Larablog\Parsers\Fields\Permalink::class,
        \Websanova\Larablog\Parsers\Fields\Redirects::class,
        \Websanova\Larablog\Parsers\Fields\Serie::class,
        \Websanova\Larablog\Parsers\Fields\Tags::class,
        \Websanova\Larablog\Parsers\Fields\Title::class,
    ],

    'paths' => [
        // All directories here will be recursively searched for all files.
    ],

    'models' => [
        'post'  => \Websanova\Larablog\Models\Post::class,
        'tag'   => \Websanova\Larablog\Models\Tag::class,
        'group' => \Websanova\Larablog\Models\Group::class,
    ],

    'tables' => [
        'prefix' => ''
    ]




    // 'fields' => [
    //     'body'        => \Websanova\Larablog\Processor\Fields\Body::class,
    //     'date'        => \Websanova\Larablog\Processor\Fields\Date::class,
    //     'description' => \Websanova\Larablog\Processor\Fields\Description::class,
    //     'image'       => \Websanova\Larablog\Processor\Fields\Image::class,
    //     'keywords'    => \Websanova\Larablog\Processor\Fields\Keywords::class,
    //     'permalink'   => \Websanova\Larablog\Processor\Fields\Permalink::class,
    //     'redirect'    => \Websanova\Larablog\Processor\Fields\Redirect::class,
    //     'tags'        => \Websanova\Larablog\Processor\Fields\Tags::class,
    //     'title'       => \Websanova\Larablog\Processor\Fields\Title::class,
    // ],

    // 'keys' => [
    //     \Websanova\Larablog\Models\Post::class => 'permalink',
    //     \Websanova\Larablog\Models\Tag::class  => 'slug',
    // ],

    // 'models' => [
    //     'post' => \Websanova\Larablog\Models\Post::class,
    // ],

    // 'parser' => \Websanova\Larablog\Processor\Parsers\LarablogParser::class,

    // 'paths' => [
    //     base_path('larablog/posts/2010'),
    // ],

    // 'relations' => [
    //     \Websanova\Larablog\Models\Post::class => ['redirects', 'tags'],
    //     \Websanova\Larablog\Models\Tag::class => [],
    // ],

    // 'tables' => [
    //     'prefix' => '',
    // ],
];
