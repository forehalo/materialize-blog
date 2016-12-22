<?php

namespace App\Repositories;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagRepository
{
    /**
     * Get all tags.
     *
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function all($columns = ['*'])
    {
        return Tag::orderBy('hot', 'desc')->get($columns);
    }

    /**
     * Get posts by given tag.
     *
     * @param $name
     * @return array|\Illuminate\Support\Collection
     */
    public function getPostsByTag($name)
    {
        $tag = Tag::where('name', $name)
            ->with(['posts' => function ($query) {
                $query->select('id', 'title', 'slug')
                    ->where('published', true)
                    ->orderBy('created_at', 'desc');
            }])
            ->first();
        $tag->increment('hot');
        return is_null($tag) ? [] : $tag->posts;
    }
}
