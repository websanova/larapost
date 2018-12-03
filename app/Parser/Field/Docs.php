<?php

namespace Websanova\Larablog\Parser\Field;

class Docs extends Series
{
    public static function process($key, $val, $data, $type = 'docs')
    {
        return parent::process($key, $val, $data, $type);
    }

    // public static function handle($key, $val, $post)
    // {
    //     preg_match_all('/\<h2\>(.*)\<\/h2\>/', $post->body, $matches);
        
    //     if (isset($matches[1]) && is_array($matches[1])) {
            
            


            
    //         // $section_list = explode(',', $val);
        
    //         // $sections = [];

    //         // foreach ($section_list as $v) {
    //         //     $v = trim($v);

    //         //     if (empty($v)) {
    //         //         continue;
    //         //     }

    //         //     $slug = str_slug($v);
                
    //         //     $section = Serie::where('slug', $slug)->first();

    //         //     if ( ! $tag) {
    //         //         $tag = Tag::create([
    //         //             'slug' => $slug,
    //         //             'name' => $v
    //         //         ]);
    //         //     }

    //         //     array_push($tags, $tag);
    //         // }
            
    //         // $tags_old = $post->tags->pluck('id')->toArray();
    //         // $tags_new = array_map(function ($v) { return $v->id; }, $tags);

    //         // $diff = array_merge(array_diff($tags_old, $tags_new), array_diff($tags_new, $tags_old));

    //         // $post->tags()->sync($tags_new);

    //         // if (count($diff) > 0) {
    //         //     echo 'Updated Tags: ' . $val . "\n";
    //         // }



    //         // TODO: User serie_id for head.

    //         // TODO: Add chapters and sections

    //         // TODO: delete any changes...

    //         print_r($matches[1]);
        


    //     }

    // }

    public function cleanup($type = 'docs')
    {
        return parent::cleanup($type);

        // TODO: Clean up chapters/sections
    }
}