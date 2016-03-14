<?php namespace App\Repositories;
use App\Models\Category;

/**
 * Class CategoryRepository.php
 * @package     App\Repositories
 * @version     1.0.0
 * @copyright   Copyright (c) 2015-2016 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
class CategoryRepository
{

    /**
     * Category Model object.
     *
     * @var Category $model
     */
    protected $model;

    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * Get all Categories.
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->orderBy('hot', 'desc')->get();
    }

    /**
     * Get by category id.
     *
     * @param $id
     */
    public function getById($id)
    {
        $category = $this->model->find($id);

        if(!is_null($category)){
            $category->hot++;
            $category->update();
        }

        return $category;
    }
}