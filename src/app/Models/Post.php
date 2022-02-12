<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;
use Websanova\Larablog\Parsers\PostParser;

class Post extends Model
{
    protected $casts = [
        'meta' => 'array',
    ];

    protected $dates = [
        'published_at',
    ];

    protected $guarded = [];

    protected $hidden = [];

    // For doc
    public function postable()
    {
        return $this->morphTo();
    }

    // public function doc()
    // {
    //     return $this->belongsTo(Doc::class);
    // }

    public function redirects()
    {
        // TODO: Use morph here for id instead of this...


        return $this->hasMany(Post::class, 'body', 'permalink');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    // public function getTypeAttribute($val)
    // {
    //     return $val ?? 'post';
    // }

    public function next()
    {
        // if type post => get prev/next by published_at
        // if type doc  => get prev/next by order

        // order by date, name
    }

    public function prev()
    {
        // order by date, name

    }


    /////////

    /**
     * The original loaded relationships for the model.
     *
     * @var array
     */
    protected $relations_original = [];

    /**
     * Set the given relationship on the model.
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
        
    }

    public function getDirtyRelationDelete(String $relation, String $key = 'id')
    {

    }







}
