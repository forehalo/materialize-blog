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

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function all()
    {
        return $this->model->orderBy('hot', 'desc')->get();
    }
}