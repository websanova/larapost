<?php

return [
    
    'name' => 'LaraBlog',
    
    'author' => 'Websanova',
    
    'posts' => [
        'uri' => 'blog',

        'src' => resource_path('larablog/posts'),

        'per_page' => 15
    ],

    'docs' => [
        'uri' => 'docs',

        'src' => resource_path('larablog/docs')
    ],

    'pages' => [
        'src' => resource_path('larablog/pages')
    ],

    'assets' => [
        'src' => resource_path('larablog/assets'),

        'dest' => public_path('larablog')
    ],

    'meta' => [
        'description' => 'LaraBlog is an easy to use drop in blogging package that can be used on it\'s own or directly within any of your Laravel apps.',
        'keywords' => 'laravel, blog, package',
        'logo' => '/img/logo-200x200.png',
        'title' => 'LaraBlog'
    ],

    'layout' => [
        'theme' => 'larablog::themes.default',

        'nav' => [
            'title' => 'LaraBlog',
            
            'links' => [
                'Blog' => '/blog',
                'Docs' => '/docs',
                'Tags' => '/blog/tags',
                'Series' => '/blog/series'
            ]
        ],

        'social' => [
            'twitter' => 'websanova',
            
            'facebook' => 'websanova',
        ],

        'footer' => [
            'title' => 'LaraBlog',

            'copy' => true,
            
            'plug' => true,
        ]
    ],

    'tables' => [
        'prefix' => ''
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

        '/blog/feed/atom' => [
            'as' => 'atom',
            'uses' => '\Websanova\Larablog\Http\Controllers\BlogController@atom'
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
            'as' => 'tag',
            'uses' => '\Websanova\Larablog\Http\Controllers\TagController@show'
        ],

        '/blog/series' => [
            'as' => 'series',
            'uses' => '\Websanova\Larablog\Http\Controllers\SerieController@index'
        ],

        '/blog/series/{slug}' => [
            'as' => 'serie',
            'uses' => '\Websanova\Larablog\Http\Controllers\SerieController@show'
        ],

        '/docs' => [
            'as' => 'docs',
            'uses' => '\Websanova\Larablog\Http\Controllers\DocController@index'
        ],

        '/docs/{slug}' => [
            'as' => 'doc',
            'uses' => '\Websanova\Larablog\Http\Controllers\DocController@show'
        ],

        '/docs/{slug}/{post_slug}' => [
            'as' => 'chapter',
            'uses' => '\Websanova\Larablog\Http\Controllers\DocController@chapter'
        ],

        '/{any}' => [
            'uses' => '\Websanova\Larablog\Http\Controllers\PostController@post',
            'where' => ['any' => '(.*)']
        ]
    ]
];
