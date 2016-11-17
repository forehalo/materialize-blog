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
}