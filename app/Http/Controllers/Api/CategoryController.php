<?php

namespace App\Http\Controllers\Api;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{

    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function categories()
    {
        return $this->category->all();
    }
}
