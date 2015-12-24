<?php

return [

	'theme' => 'larablog::themes.default',
	
	'perpage' => 15,

	'table' => 'blog_posts',

	'folder_path' => 'blog',
	
	'site_pages' => [
		'/' => 'Home',
		'/blog' => 'Blog'
	],

	'site_author' => 'LaraBlog',

	'site_name' => 'LaraBlog',

	'site_path' => '/blog',

	'search_path' => '/blog/search',

	'search_fields' => ['title', 'body'],

	'sitemap_path' => '/blog/sitemap',

	'feed_path' => '/blog/feed'
];