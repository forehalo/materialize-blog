<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{

    /**
     * Get all posts order by publish date.
     *
     * @param int $limit
     * @param array $columns
     * @param boolean $onlyPublished
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($limit = 8, $columns = ['*'], $onlyPublished = true)
    {
        $prepare = Post::orderBy('created_at', 'desc');

        if ($onlyPublished) {
            $prepare = $prepare->where('published', true)->with('tags');
        }

        return $prepare->paginate((int)$limit, $columns)->toArray();
    }
}
