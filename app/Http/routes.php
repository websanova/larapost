<?php

Route::get(config('larablog.site_path'), '\Websanova\Larablog\Http\Controllers\PostController@index');
Route::get(config('larablog.search_path'), '\Websanova\Larablog\Http\Controllers\PostController@search');
Route::get(config('larablog.opensearch_path'), '\Websanova\Larablog\Http\Controllers\BlogController@opensearch');
Route::get(config('larablog.sitemap_path'), '\Websanova\Larablog\Http\Controllers\BlogController@sitemap');
Route::get(config('larablog.feed_path'), '\Websanova\Larablog\Http\Controllers\BlogController@feed');

Route::get(config('larablog.tags_path'), '\Websanova\Larablog\Http\Controllers\TagController@index');
Route::get(config('larablog.tags_path') . '/{slug}', '\Websanova\Larablog\Http\Controllers\TagController@show');

Route::get('/{any}', '\Websanova\Larablog\Http\Controllers\PostController@post')->where('any', '(.*)');
