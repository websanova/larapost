<?php

return [

	'theme' => 'default',
	
	'perpage' => 15,

	'table' => 'blog',

	'path' => 'blog',
	
	'site' => [
		
		'name' => 'LaraBlog',
		
		'path' => '/blog',

		'nav' => [
			'/' => 'Home',
			'/blog' => 'Blog'
		],

		'adcode' => '',
		
		'analytics' => ''
	],

	'search' => [
	
		'path' => '/blog/search',

		'fields' => ['title', 'body']
	]
];