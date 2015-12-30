<?php

Route::get(config('larablog.site_path'), '\Websanova\Larablog\Http\PostController@index');
Route::get(config('larablog.search_path'), '\Websanova\Larablog\Http\PostController@search');
Route::get(config('larablog.opensearch_path'), '\Websanova\Larablog\Http\BlogController@opensearch');
Route::get(config('larablog.sitemap_path'), '\Websanova\Larablog\Http\BlogController@sitemap');
Route::get(config('larablog.feed_path'), '\Websanova\Larablog\Http\BlogController@feed');

Route::get('/{any}', '\Websanova\Larablog\Http\PostController@post')->where('any', '(.*)');
