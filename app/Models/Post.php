<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The mass assignable attributes.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'summary', 'origin', 'body', 'category_id', 'published'];

    /**
     * The attributes should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['origin'];

    /**
     * Many to many relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tag', 'post_id');
    }

    /**
     * One to many relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * One to many relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Guest scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShow($query)
    {
        return $query->wherePublished(1);
    }

    /**
     * Manager scope.
     *
     * @param \Illuminate\Database\Eloquent\Builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeManage($query)
    {
        return $query->select('id', 'slug', 'title', 'published', 'created_at');
    }
}
