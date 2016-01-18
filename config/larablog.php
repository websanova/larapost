<?php

return [

    'app' => [
        'path' => 'blog',
        'theme' => 'larablog::themes.default',
        'meta' => 'larablog::layout.meta'
    ],

    'table' => [
        'prefix' => 'lb'
    ],

    'meta' => [
        'description' => 'LaraBlog is an easy to use drop in blogging package that can be used on it\'s own or directly within any of your Laravel apps.',
        'keywords' => 'laravel, blog, package',
        'logo' => '/img/logo-200x200.png',
        'title' => 'LaraBlog'
    ],

    'routes' => [
        '/sitemap' => [
            'as' => 'sitemap',
            'uses' => '\Websanova\Larablog\Http\Controllers\BlogController@sitemap'
        ],
        
        '/blog' => [
            'as' => 'blog',
            'uses' => '\Websanova\Larablog\Http\Controllers\PostController@index'
        ],

        '/blog/feed' => [
            'as' => 'feed',
            'uses' => '\Websanova\Larablog\Http\Controllers\BlogController@feed'
        ],

        '/blog/search' => [
            'as' => 'search',
            'uses' => '\Websanova\Larablog\Http\Controllers\PostController@search'
        ],

        '/blog/search.xml' => [
            'as' => 'opensearch',
            'uses' => '\Websanova\Larablog\Http\Controllers\BlogController@opensearch'
        ],

        '/blog/tags' => [
            'as' => 'tags',
            'uses' => '\Websanova\Larablog\Http\Controllers\TagController@index'
        ],

        '/blog/tags/{slug}' => [
            'uses' => '\Websanova\Larablog\Http\Controllers\TagController@show'
        ],

        '/blog/series' => [
            'as' => 'series',
            'uses' => '\Websanova\Larablog\Http\Controllers\SeriesController@index'
        ],

        '/blog/series/{slug}' => [
            'uses' => '\Websanova\Larablog\Http\Controllers\SeriesController@show'
        ],

        '/{any}' => [
            'uses' => '\Websanova\Larablog\Http\Controllers\PostController@post',
            'where' => ['any' => '(.*)']
        ]
    ],

    'nav' => [
        'title' => 'LaraBlog',
        'links' => [
            '/blog' => 'Blog',
            '/blog/tags' => 'Tags',
            '/blog/series' => 'Series'
        ]
    ],

    'posts' => [
        'perpage' => 15
    ],

    'site' => [
        'author' => 'Websanova',
        'name' => 'LaraBlog',
    ],

    'social' => [
        'twitter' => 'websanova',
        'facebook' => 'websanova',
    ],

    'footer' => [
        'copy' => true,
        'plug' => true,
    ],

    'site_headers' => [],

    'site_footers' => [],

    'post_headers' => [],

    'post_footers' => [],
];
