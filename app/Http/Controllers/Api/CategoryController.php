<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    /**
     * CategoryRepository
     * @var CategoryRepository
     */
    protected $category;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Get all categories.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->category->all();
    }

    /**
     * Get posts with given category.
     *
     * @param $name
     * @return array|\Illuminate\Support\Collection
     */
    public function getPostsByCategory($name)
    {
        return $this->category->getPostsByName($name);
    }
}
