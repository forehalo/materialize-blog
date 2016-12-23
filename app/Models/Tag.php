<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * The mass assignable attributes.
     * 
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Many to many relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany('App\Models\Post', 'post_tag', 'tag_id');
    }

    public function postTags()
    {
        return $this->hasMany('App\Models\PostTag', 'tag_id');
    }
}
