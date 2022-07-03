<?php

namespace Websanova\Larablog;

use Websanova\Larablog\Parsers\LarablogParser;

class Larablog
{
    public static function build()
    {
        $parser = config('larablog.parser');
        $data   = $parser::getData();

        // Error

        if (isset($data['errors'])) {
            return [
                'data'   => $data,
                'status' => 'error',
            ];
        }

        // Doc

        if (isset($data['docs'])) {
            $model = config('larablog.models.doc');

            $model::truncate();

            foreach ($data['docs'] as $doc) {
                $doc->model = $model::create($doc->attributes);
            }
        }

        // Serie

        if (isset($data['series'])) {
            $model = config('larablog.models.serie');

            $model::truncate();

            foreach ($data['series'] as $serie) {
                $serie->model = $model::create($serie->attributes);
            }
        }

        // Group

        if (isset($data['groups'])) {
            $model = config('larablog.models.group');

            $model::truncate();

            foreach ($data['groups'] as $group) {
                $group->attributes['doc_id'] = $group->relations['doc']->model->id;

                $group->model = $model::create($group->attributes);
            }
        }

        // Tag

        if (isset($data['tags'])) {
            $model = config('larablog.models.tag');

            $model::truncate();

            foreach ($data['tags'] as $tag) {
                $tag->model = $model::create($tag->attributes);
            }
        }

        // Post

        if (isset($data['posts'])) {
            $model = config('larablog.models.post');

            $model::truncate();

            foreach ($data['posts'] as $post) {
                if (isset($post->relations['doc'])) {
                    $post->attributes['doc_id'] = $post->relations['doc']->model->id;
                }

                if (isset($post->relations['serie'])) {
                    $post->attributes['serie_id'] = $post->relations['serie']->model->id;
                }

                if (isset($post->relations['group'])) {
                    $post->attributes['group_id'] = $post->relations['group']->model->id;
                }

                $post->model = $model::create($post->attributes);

                // Tags

                if (isset($post->relations['tags'])) {
                    $ids = [];

                    foreach ($post->relations['tags'] as $tag) {
                        $ids[]= $tag->model->id;
                    }

                    $post->model->tags()->sync($ids);
                }

                // Redirects

                if (isset($post->relations['redirects'])) {
                    foreach ($post->relations['redirects'] as $redirect) {
                        $redirect->attributes['redirect_id'] = $post->model->id;

                        $redirect->model = $model::create($redirect->attributes);
                    }
                }
            }
        }

        // Success

        return [
            'data'   => $data,
            'status' => 'success',
        ];
    }
}
