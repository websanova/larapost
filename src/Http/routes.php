<?php

Route::get('/', '\Websanova\Larablog\Http\HomeController@index');

Route::get(config('larablog.site_path'), '\Websanova\Larablog\Http\BlogController@index');
Route::get(config('larablog.search_path'), '\Websanova\Larablog\Http\BlogController@search');
Route::get(config('larablog.sitemap_path'), '\Websanova\Larablog\Http\BlogController@sitemap');
Route::get(config('larablog.feed_path'), '\Websanova\Larablog\Http\BlogController@feed');

Route::get('/{any}', '\Websanova\Larablog\Http\BlogController@post')->where('any', '(.*)');
