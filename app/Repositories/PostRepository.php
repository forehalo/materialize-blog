<?php namespace App\Repositories;

use App\Models\Post;

/**
 * Class BlogRepository.php
 * @package
 * @version     1.0.0
 * @copyright   Copyright (c) 2015 forehalo <http://www.forehalo.top>
 * @author      forehalo <forehalo@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl.html   LGPL
 */
class PostRepository
{
    protected $model;


    /**
     * BlogRepository constructor.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    /**
     * Get all posts.
     *
     * @param int $n pagination
     * @return mixed
     */
    public function all($n = null)
    {
        $posts = $this->model
                    ->select('id', 'title', 'summary', 'comment_count', 'view_count', 'favorite_count', 'created_at')
                    ->wherePublished(true)
                    ->orderBy('created_at', 'desc');

        return $n ? $posts->paginate($n) : $posts->get();
    }

    /**
     * Get post body.
     *
     * @param $id
     * @return mixed
     */
    public function body($id)
    {
        return $this->getByColumn($id)->body;
    }

    /**
     * Get post by given column.
     *
     * @param string $value column value.
     * @param string $column column name, default={id}
     * @return
     */
    public function getByColumn($value, $column = 'id')
    {
        return $this->model->where($column, $value)->first();
    }


}