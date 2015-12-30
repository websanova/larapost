<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Models\Tag;

class Tags
{
	public static function process($key, $val, $data)
	{
        return $data;
	}

	public static function handle($key, $val, $post)
	{
		$tag_list = explode(',', $val);
		
		$tags = [];

		foreach ($tag_list as $v) {
			$v = trim($v);

			if (empty($v)) {
				continue;
			}

			$slug = str_slug($v);
			
			$tag = Tag::where('slug', $slug)->first();

			if ( ! $tag) {
				$tag = Tag::create([
					'slug' => $slug,
					'name' => $v
				]);
			}

			array_push($tags, $tag->id);
		}
		
		$diff = array_merge(array_diff($post->tags->lists('id')->toArray(), $tags), array_diff($tags, $post->tags->lists('id')->toArray()));

		$post->tags()->sync($tags);

		if (count($diff) > 0) {
			echo 'Updated Tags: ' . $val . "\n";
		}
	}
}