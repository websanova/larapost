<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Larablog;
use Illuminate\Support\Facades\DB;
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

			array_push($tags, $tag);
		}
		
		$tags_old = $post->tags->pluck('id')->toArray();
		$tags_new = array_map(function ($v) { return $v->id; }, $tags);

		$diff = array_merge(array_diff($tags_old, $tags_new), array_diff($tags_new, $tags_old));

		$post->tags()->sync($tags_new);

		if (count($diff) > 0) {
			echo 'Updated Tags: ' . $val . "\n";
		}
	}

	public function cleanup()
	{
		$prefix = config('larablog.table.prefix');

        // Clean out any old pivot data.
        DB::statement("DELETE {$prefix}post_tag FROM {$prefix}post_tag LEFT JOIN {$prefix}posts ON {$prefix}post_tag.post_id = {$prefix}posts.id WHERE NOT({$prefix}post_tag.post_id = {$prefix}posts.id AND {$prefix}posts.deleted_at = NULL AND {$prefix}posts.type='post')");

        // TODO: convert to eloquent?
        DB::table($prefix . 'tags')->update([
            'posts_count' => DB::raw("(SELECT COUNT(*) FROM {$prefix}post_tag WHERE {$prefix}post_tag.tag_id = {$prefix}tags.id)")
        ]);
        
        Tag::where('posts_count', 0)->delete();
	}
}