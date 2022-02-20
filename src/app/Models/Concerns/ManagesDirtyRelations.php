<?php

namespace Websanova\Larablog\Models\Concerns;

trait ManagesDirtyRelations {

    /**
     * The original relationships loaded for the model.
     *
     * @var array
     */
    protected $relations_original = [];

    /**
     * Back the original relation if not already set
     * and set the new relation to it's new value.
     *
     * @param  string  $relation
     * @param  mixed  $value
     * @return $this
     */
    public function fillRelation($relation, $value)
    {
        if (!isset($this->relations_original[$relation])) {
            $this->relations_original[$relation] = $this->{$relation};
        }

        $this->setRelation($relation, $value);

        return $this;
    }

    public function isDirtyRelation(String $relation, String $key = 'id')
    {
        if (
            $this->relationLoaded($relation) &&
            isset($this->relations_original[$relation])
        ) {
            $old_keys = array_unique($this->relations_original[$relation] ? $this->relations_original[$relation]->pluck($key)->toArray() : []);
            $new_keys = array_unique($this->{$relation} ? $this->{$relation}->pluck($key)->toArray() : []);

            if (
                array_diff($old_keys, $new_keys) ||
                array_diff($new_keys, $old_keys)
            ) {
                return true;
            }
        }

        return false;
    }

    public function getDirtyRelationCreate(String $relation, String $key = 'id')
    {
        $mod = collect();

        $old = ($this->relations_original[$relation] ?? collect())->keyBy($key);
        $cur = ($this->{$relation} ?? collect());

        foreach ($cur as $model) {
            if (!isset($old[$model->{$key}])) {
                $mod->push($model);
            }
        }

        return $mod;
    }

    public function getDirtyRelationDelete(String $relation, String $key = 'id')
    {
        $mod = collect();

        $old = ($this->relations_original[$relation] ?? collect());
        $cur = ($this->{$relation} ?? collect())->keyBy($key);

        foreach ($old as $model) {
            if (!isset($cur[$model->{$key}])) {
                $mod->push($model);
            }
        }

        return $mod;
    }
}
