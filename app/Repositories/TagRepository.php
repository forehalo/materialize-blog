<?php namespace App\Repositories;
use App\Models\Tag;

/**
 * Class TagRepository.php
 * @package     App\Repositories
 * @version     1.0.0
 * @copyright   Copyright (c) 2015-2016 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
class TagRepository
{
    /**
     * Tag Model object.
     *
     * @var Tag $model
     */
    protected $model;

    /**
     * TagRepository constructor.
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    /**
     * Get all tags
     *
     * @return mixed
     */
    public function all()
    {
        return $this->model->orderBy('hot', 'desc')->get();
    }

    /**
     * Get tag by id.
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        $tag = $this->model->find($id);

        if(!is_null($tag)){
            $tag->hot++;
            $tag->update();
        }
        return $tag;
    }
}