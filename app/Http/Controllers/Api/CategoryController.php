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
     * CategoryController construct
     * @param CategoryRepository $category
     */
    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Get all categories
     * @return \Illuminate\Response\JsonReponse
     */
    public function all()
    {
        return $this->category->all();
    }
}
