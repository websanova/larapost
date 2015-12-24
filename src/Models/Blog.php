<?php

namespace Websanova\Larablog\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
	protected $dates = ['published_at'];

	public $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        $this->table = config('larablog.table');
    }

    public function scopeSearch($q, $search)
    {
        return $q->whereRaw("MATCH (`" . implode('`, `', config('larablog.search.fields')) . "`) AGAINST (?)" , [$search]);
    }

    public function getMetaAttribute($val)
    {
    	return json_decode($val);
    }
}
