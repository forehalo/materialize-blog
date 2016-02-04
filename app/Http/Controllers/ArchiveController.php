<?php

namespace App\Http\Controllers;

/**
 * Class ArchiveController.php
 * @package     App\Http\Controllers
 * @version     1.0.0
 * @copyright   Copyright (c) 2015-2016 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArchiveController extends Controller
{
    /**
     * CategoryRepository object.
     *
     * @var CategoryRepository $category
     */
    protected $category;

    /**
     * TagRepository object.
     *
     * @var TagRepository $tag
     */
    protected $tag;

    /**
     * PostRepository object.
     *
     * @var PostRepository $post
     */
    protected $post;

    /**
     * ArchiveController constructor.
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
     * Get all categories used to group posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupByCategory()
    {
        $categories = $this->category->all();

        return view('front.archive.category', compact('categories'));
    }

    /**
     * Redirect to categories with default category.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showCategory($id)
    {
        $category = $this->category->getById($id);

        return redirect('/categories')->with('default', $category);
    }

    /**
     * Get all posts grouped by create date.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupByDate()
    {
        $posts = $this->post->all();
        $group = [];

        foreach ($posts as $post) {
            $date = date_parse($post->created_at);
            $mYear = $date['year'];
            $mMonth = $date['month'];

            // Month or Year not exists current.
            if(!array_key_exists($mYear, $group)){
                $group[$mYear] = [];
            }
            if(!array_key_exists($mMonth, $group[$mYear])){
                $group[$mYear][$mMonth] = [];
            }
            array_push($group[$mYear][$mMonth], $post);
        }

        return view('front.archive.date', compact('group'));
    }

    /**
     * Get all Tags used to group posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupByTag()
    {
        $tags = $this->tag->all();

        return view('front.archive.tag', compact('tags'));
    }

    /**
     * Redirect to tags with default tag.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showTag($id)
    {
        $tag = $this->tag->getById($id);

        return redirect('/tags')->with('default', $tag);
    }
}
