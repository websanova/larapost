<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Models\Blog;

class RedirectFrom
{
	public static function process($key, $val, $data)
	{
        return $data;
	}

	public static function handle($key, $val, $post)
	{
		if ( ! is_array($val)) {
			$val = [$val];
		}

		foreach ($val as $redirect_from) {

			echo 'Redirect: ' . $redirect_from . "\n";

			$post = Blog::create([
				'slug' => $redirect_from,
				'title' => '',
				'body' => '',
				'type' => 'redirect',
				'meta' => json_encode([
					'redirect_to' => $post->slug
				])
			]);
		}
	}
}