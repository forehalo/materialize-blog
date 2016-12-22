<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{

    /**
     * Get all categories order by hot.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*'])
    {
        return Category::orderBy('hot', 'desc')->get($columns);
    }

    /**
     * Get posts with given category.
     *
     * @param string $name
     * @return array|\Illuminate\Support\Collection
     */
    public function getPostsByName($name)
    {
        $category = Category::where('name', $name)
            ->with(['posts' => function ($query) {
                $query->select('id', 'title', 'slug', 'category_id')
                    ->where('published', true)
                    ->orderBy('created_at', 'desc');
            }])
            ->first();
        $category->increment('hot');
        return is_null($category) ? [] : $category->posts;
    }
}
