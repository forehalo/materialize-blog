<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['origin'];

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['post_id', 'name', 'email', 'blog', 'origin', 'content', 'parent_id'];

    /**
     * One to many relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Comment', 'id', 'parent_id')->select('id', 'name');
    }
}
