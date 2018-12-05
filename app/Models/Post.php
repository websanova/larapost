<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $dates = ['published_at'];

	public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.tables.prefix') . 'posts';
    }

    public function tags()
    {
        return $this->belongsToMany('Websanova\Larablog\Models\Tag', config('larablog.tables.prefix') . 'post_tag');
    }

    public function serie()
    {
        return $this->belongsTo('Websanova\Larablog\Models\Serie');
    }

    public function scopeSearch($q, $search)
    {
        return $q->whereRaw("MATCH (`title`, `body`) AGAINST (?)" , [$search]);
    }

    public function getUrlAttribute()
    {
        // if ($this->type === 'doc') {
        //     $url = route('docs') . (isset($this->serie->slug) ? '/' . $this->serie->slug : '');
        // }
        // elseif ($this->type === 'post') {
        //     $url = route('blog');
        // }
        // else {
        //     $url = url();
        // }

        // dd(url());

        return url('/') . $this->permalink;
    }

    public function getFullTitleAttribute()
    {
        return ($this->serie ? $this->serie->title . ' :: ' : '') . $this->title;
    }

    public function getMetaAttribute($val)
    {
    	return json_decode($val);
    }

    public function getButtonsAttribute()
    {
        return $this->meta->buttons;
    }

    public function getImgAttribute()
    {
        return url('/') . (@$this->meta->img ?: config('larablog.meta.logo'));
    }
}
