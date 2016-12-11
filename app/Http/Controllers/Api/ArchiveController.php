<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArchiveController extends Controller
{

    /**
     * CategoryRepository
     *
     * @var CategoryRepository
     */
    protected $category;

    /**
     * TagRepository
     *
     * @var TagRepository
     */
    protected $tag;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $category
     * @param TagRepository $tag
     */
    public function __construct(CategoryRepository $category, TagRepository $tag)
    {
        $this->category = $category;
        $this->tag = $tag;
    }

    /**
     * Get all categories.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function categories()
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

    /**
     * Get all tags.
     *
     * @return \Illuminate\Support\Collection
     */
    public function tags()
    {
        return $this->tag->all();
    }

    /**
     * Get posts by given tag.
     *
     * @param $name
     * @return array|\Illuminate\Support\Collection
     */
    public function getPostsByTag($name)
    {
        return $this->tag->getPostsByTag($name);
    }
}
