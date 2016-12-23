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

    /**
     * Pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postTags()
    {
        return $this->hasMany('App\Models\PostTag', 'tag_id');
    }

    /**
     * Mutate space to hyphen('-') in name column.
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_replace(' ', '-', $value);
    }


}
