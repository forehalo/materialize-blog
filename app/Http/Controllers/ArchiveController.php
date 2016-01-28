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
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ArchiveController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function groupByCategory()
    {
        $categories = $this->category->all();

        return view('front.archive.category', compact('categories'));
    }

    public function groupByTime()
    {

    }

    public function groupByTag()
    {

    }
}
