<?php

namespace Websanova\Larablog\Processor;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Websanova\Larablog\Models\Post;

class Processor
{
    //

    private $error   = [];
    private $success = [];

    //

    private $create = [];
    private $delete = [];
    private $update = [];

    /*
     * Process all files in all paths.
     *
     * @return Void
     */
    public function parse()
    {
        $paths = $this->getPaths();
        $files = $this->getFiles($paths);

        foreach ($files as $file) {
            $parse  = $this->getParsed($file);
            $result = isset($parse['error']) ? 'error' : 'success';

            $this->{$result}[$file] = $parse;
        }

        return $this;
    }

    public function process()
    {
        $models_by_class = [];

        if ($this->isParseErrors()) {
            return;
        }

        // Gather up all the models (direct and relations).
        foreach ($this->getParseSuccess() as $file) {
            $post = $this->initPost($file);

            $models_by_class[$post::class][]= $post;

            foreach ($post->getRelations() as $relation_key => $relation_models) {
                foreach ($relation_models as $relation_model) {
                    $models_by_class[$relation_model::class][]= $relation_model;
                }
            }
        }

        // Compare create/delete/update.
        foreach ($models_by_class as $model_class => $models) {
            $attr_key        = $this->getAttributeKey($model_class);
            $class_relations = $this->getClassRelations($model_class);

            $db  = $model_class::with($class_relations)->get();
            $raw = (new Collection($models))->unique($attr_key);

            $this->create[$model_class] = $raw->whereNotIn($attr_key, $db->pluck($attr_key)->toArray());
            $this->delete[$model_class] = $db->whereNotIn($attr_key, $raw->pluck($attr_key)->toArray());
            $this->update[$model_class] = collect();

            // Updates require a bit of finessing for dirty checks.
            $db     = $db->keyBy($attr_key);
            $update = $raw->whereIn($attr_key, $db->pluck($attr_key)->toArray());

            foreach ($update as $model_raw) {
                $model_db = $db[$model_raw->{$attr_key}];

                // Generic fill which will work nicely for create/update
                // and any isDirty checks for diff print out later on.
                $model_db->fill($model_raw->withoutRelations()->toArray());

                foreach ($model_db->getRelations() as $relation_key => $relation_models) {
                    $model_db->fillRelation($relation_key, $model_raw->{$relation_key} ?? null);
                }

                // Check for any changes on the model.
                if ($this->isModelDirty($model_db)) {
                    $this->update[$model_class]->push($model_db);
                }
            }
        }

        return $this;
    }

    public function save()
    {
        if ($this->isParseErrors()) {
            return;
        }

        // We already have our data here organized
        // into models so just save on create/update.
        foreach (['create', 'update'] as $op) {
            foreach ($this->{$op} as $model_class => $models) {
                foreach ($models as $model) {
                    $model->save();
                }
            }
        }

        // Reload all the db data, at this point there
        // should be no new data that is NOT in the db.
        $db              = [];
        $class_relations = $this->getRelations();

        foreach ($class_relations as $class => $relations) {
            $attr_key = $this->getAttributeKey($class);

            $db[$class] = $class::with($relations)->get()->keyBy($attr_key);
        }

        // Hook up all the model relations.
        foreach (['create', 'update'] as $op) {
            foreach ($this->{$op} as $model_class => $models) {
                foreach ($models as $model) {
                    foreach ($model->getRelations() as $relation_key => $relation_models) {
                        if (!$model->isDirtyRelation($relation_key)) {
                            continue;
                        }

                        $attr_key = $this->getAttributeKey($model->{$relation_key}()->getRelated()::class);

                        $relation_models_create = $model->getDirtyRelationCreate($relation_key, $attr_key);
                        $relation_models_delete = $model->getDirtyRelationDelete($relation_key, $attr_key);

                        // Create

                        $models = [];

                        foreach ($relation_models_create as $relation_model_create) {
                            $models[]= $db[$relation_model_create::class][$relation_model_create->{$attr_key}];
                        }

                        $model->{$relation_key}()->saveMany($models);

                        // Delete

                        $ids = [];

                        foreach ($relation_models_delete as $relation_model_delete) {
                            $ids[]= $db[$relation_model_delete::class][$relation_model_delete->{$attr_key}]->id;
                        }

                        if (method_exists($model->{$relation_key}(), 'detach')) {
                            $model->{$relation_key}()->detach($ids);
                        }
                        elseif (method_exists($model->{$relation_key}(), 'dissociate')) {
                            $model->{$relation_key}()->dissociate();
                        }
                        else {
                            $model->{$relation_key}()->whereIn('id', $ids)->delete();
                        }
                    }
                }
            }
        }

        // Wipe out deletes and associated relations.
        foreach ($this->delete as $model_class => $models) {
            foreach ($models as $model) {
                $attr_key = $this->getAttributeKey($model::class);

                $model_db = $db[$model::class][$model->{$attr_key}];

                foreach ($model_db->getRelations() as $relation_key => $relation_models) {
                    $model_db->{$relation_key}()->delete();
                }

                $model_db->delete();
            }
        }
    }

    /*
     * Get error formatted.
     *
     * @return Array
     */
    public function getError(String $code, String $msg)
    {
        return [
            'error' => [
                'code' => $code,
                'msg'  => $msg,
            ]
        ];
    }

    /*
     * Loop through all paths to collect all files.
     *
     * @param  Array $paths
     * @return Array
     */
    public function getFiles(Array $paths = [])
    {
        $files = [];

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $files = array_merge($files, $this->getFilesInDir($path));
            }
        }

        return $files;
    }

    /*
     * Get all the files in a directory recursively.
     *
     * @param  String $dir
     * @return Array
     */
    public function getFilesInDir(String $dir = null)
    {
        $files = [];

        if (is_dir($dir)) {
            $paths = scandir($dir);

            foreach ($paths as $path) {
                if ($path === '.' || $path === '..') {
                    continue;
                }

                $path = $dir . '/' . $path;

                if (is_file($path)) {
                    $files[]= $path;
                }
                elseif (is_dir($path)) {
                    $files = array_merge($files, $this->getFilesInDir($path));
                }
            }
        }

        return $files;
    }

    public function getAttributeKey(String $model_class)
    {
        return config('larablog.keys.' . $model_class);
    }

    public function getClassRelations(String $model_class)
    {
        return config('larablog.relations.' . $model_class);
    }

    public function getFieldClass(String $key)
    {
        return config('larablog.fields.' . $key);
    }

    public function getModelsCreate()
    {
        return $this->create;
    }

    public function getModelsDelete()
    {
        return $this->delete;
    }

    public function getModelsUpdate()
    {
        return $this->update;
    }

    public function getPaths()
    {
        return config('larablog.paths');
    }

    public function getParseErrors()
    {
        return $this->error;
    }

    public function getParseSuccess()
    {
        return $this->success;
    }

    public function getParser()
    {
        return config('larablog.parser');
    }

    public function getParsed(String $file = null)
    {
        if (is_file($file)) {
            $contents = file_get_contents($file);

            try {
                $parser = $this->getParser();

                return $parser::parse($contents);
            }
            catch(Exception $e) {
                return $this->getError('invalid', 'Format: ' . $e->getMessage());
            }
        }
        else {
            return $this->getError('fdne', 'File does not exist');
        }
    }

    public function getPostClass()
    {
        return config('larablog.post');
    }

    public function getRelations()
    {
        return config('larablog.relations');
    }

    public function initPost(Array $file = null)
    {
        $class = $this->getPostClass();
        $post  = new $class;

        foreach ($file as $key => $val) {
            $class = $this->getFieldClass($key);
            $post  = $class::parse($post, $file);
        }

        return $post;
    }

    public function isModelDirty($model_db)
    {
        if ($model_db->isDirty()) {
            return true;
        }

        foreach ($model_db->getRelations() as $relation_key => $relation_models) {
            $attr_key = $this->getAttributeKey($model_db->{$relation_key}()->getRelated()::class);

            if ($model_db->isDirtyRelation($relation_key, $attr_key)) {
                return true;
            }
        }

        return false;
    }

    public function isParseErrors()
    {
        return count($this->getParseErrors()) ? true : false;
    }
}