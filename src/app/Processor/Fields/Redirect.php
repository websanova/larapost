<?php

namespace Websanova\Larablog\Processor\Fields;

use Websanova\Larablog\Models\Post;

class Redirect
{
    public static function parse(Array $record, Array $file)
    {
        foreach($file['redirect'] as $redirect) {
            $data = [
                'permalink' => '/' . trim($redirect, '/'),
                'body'      => '/' . trim($file['permalink'][0], '/'),
                'type'      => 'redirect',
            ];

            $post = Post::query()
                ->where('permalink', $data['permalink'])
                ->where('body', $data['body'])
                ->where('type', $data['type'])
                ->first();

            if (!$post) {
                $post = Post::create($data);
            }

            $record['relations']['redirects'][]= $post;
        }

        return $record;
    }
}