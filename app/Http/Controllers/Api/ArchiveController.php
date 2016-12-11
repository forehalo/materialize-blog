<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArchiveController extends Controller
{

    /**
     * @var CategoryRepository
     */
    protected $category;

    /**
     * @var TagRepository
     */
    protected $tag;

    /**
     * @var PostRepository
     */
    protected $post;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $category
     * @param TagRepository $tag
     * @param PostRepository $post
     */
    public function __construct(CategoryRepository $category, TagRepository $tag, PostRepository $post)
    {
        $this->category = $category;
        $this->tag = $tag;
        $this->post = $post;
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

    /**
     * Group all dates with posts published, group by year/month.
     *
     * @return array
     */
    public function getExistDates()
    {
        return $this->post->groupDates();
    }

    public function getPostsByDate($date)
    {
        return $this->post->getPostsByYearMonth($date);
    }
}
