<?php

namespace Websanova\Larablog\Parser\Field;

use Websanova\Larablog\Models\Post;

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

        $redirects = [];

        foreach ($val as $redirect_from) {
            $redirect = Post::where('slug', $redirect_from)->first();

            if ($redirect && $redirect->type !== 'redirect') {
                echo '***********************************************************************' . "\n";
                echo '* WARNING: Slug exists: ' . $redirect->slug . "\n";
                echo '***********************************************************************' . "\n";
            }

            $data = [
                'slug' => $redirect_from,
                'title' => '',
                'body' => '',
                'type' => 'redirect',
                'meta' => json_encode([
                    'redirect_to' => $post->slug
                ])
            ];

            if ($redirect) {
                $redirect->fill($data);

                if ($redirect->isDirty()) {
                    $redirect->save();
                    echo 'Update Redirect: ' . $redirect_from . "\n";
                }
            }
            else {
                $redirect = Post::create($data);

                echo 'New Redirect: ' . $redirect_from . "\n";
            }

            array_push($redirects, $redirect->slug);
        }

        self::delete($redirects, $post);
    }

    public static function delete($redirects, $post)
    {
        $posts = Post::whereNotIn('slug', $redirects)
            ->where('type', 'redirect')
            ->where('meta', 'LIKE', '%"redirect_to":"' . str_replace('/', "\\\/", $post->slug) . '"%')
            ->get();

        if ( ! $posts->isEmpty()) {
            Post::whereIn('id', $posts->lists('id')->toArray())->delete();

            foreach ($posts as $p) {
                echo 'Removed Redirect: ' . $p->slug . "\n";
            }
        }
    }
}