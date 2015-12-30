<?php

return [

	'theme' => 'larablog::themes.default',
	
	'perpage' => 15,

	'table_posts' => 'blog_posts',
	
	'table_tags' => 'blog_tags',

	'table_post_tag' => 'blog_post_tag',

	'folder_path' => 'blog',
	
	'site_pages' => [
		'/' => 'Home',
		'/blog' => 'Blog'
	],

	'site_logo' => '/img/logo-200x200.png',

	'site_description' => 'LaraBlog is an easy to use drop in blogging package that can be used on it\'s own or directly within any of your Laravel apps.',

	'site_keywords' => 'laravel, blog, package',

	'site_title' => 'LaraBlog',

	'site_author' => 'LaraBlog',

	'site_name' => 'LaraBlog',

	'site_path' => '/blog',

	'site_meta' => 'larablog::layout.meta',

	'search_path' => '/blog/search',

	'opensearch_path' => '/blog/search.xml',

	'search_fields' => ['title', 'body'],

	'sitemap_path' => '/blog/sitemap',

	'feed_path' => '/blog/feed',

	'site_headers' => [],

	'site_footers' => [],

	'page_headers' => [],

	'page_footers' => [],
];