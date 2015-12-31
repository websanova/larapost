<?php

if (config('larablog.site_path') !== null) {
	Route::get(config('larablog.site_path'), '\Websanova\Larablog\Http\Controllers\PostController@index');
}

if (config('larablog.search_path') !== null) {
	Route::get(config('larablog.search_path'), '\Websanova\Larablog\Http\Controllers\PostController@search');
}

if (config('larablog.opensearch_path') !== null) {
	Route::get(config('larablog.opensearch_path'), '\Websanova\Larablog\Http\Controllers\BlogController@opensearch');
}

if (config('larablog.sitemap_path') !== null) {
	Route::get(config('larablog.sitemap_path'), '\Websanova\Larablog\Http\Controllers\BlogController@sitemap');
}

if (config('larablog.feed_path') !== null) {
	Route::get(config('larablog.feed_path'), '\Websanova\Larablog\Http\Controllers\BlogController@feed');
}

if (config('larablog.tags_path') !== null) {
	Route::get(config('larablog.tags_path'), '\Websanova\Larablog\Http\Controllers\TagController@index');
}

if (config('larablog.tags_path') !== null) {
	Route::get(config('larablog.tags_path') . '/{slug}', '\Websanova\Larablog\Http\Controllers\TagController@show');
}

if (config('larablog.catchall_path') !== null) {
	Route::get(config('larablog.catchall_path') . '/{any}', '\Websanova\Larablog\Http\Controllers\PostController@post')->where('any', '(.*)');
}
