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
     * ArchiveController constructor.
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
     * Get all categories used to group posts.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function groupByCategory()
    {
        $categories = $this->category->all();

        return view('front.archive.category', compact('categories'));
    }

    public function groupByDate()
    {
        return view('front.archive.date');
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
}
